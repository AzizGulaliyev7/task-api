<?php

namespace App\Http\Requests;

use App\Http\Controllers\Traits\ResponseAble;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class EmployeeCreateRequest extends FormRequest
{
    use ResponseAble;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_id'        => 'required|exists:companies,id',
            'passport_number'   => 'required|min:9',
            'first_name'        => 'required|min:2',
            'last_name'         => 'required|min:2',
            'phone_number' => [
                'required',
                'unique:employees,phone_number',
                'regex:/\+(9[976]\d|8[987530]\d|6[987]\d|5[90]\d|42\d|3[875]\d|2[98654321]\d|9[8543210]|8[6421]|6[6543210]|5[87654321]|4[987654310]|3[9643210]|2[70]|7|1)\d{1,14}$/'
            ]
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        return $this->sendError(
            $errors,
            'Validation error',
            422
        );
    }

    
    public function messages()
    {
        return [
            'company_id.required'       => 'Korxona ID si kiritilishi shart',
            'company_id.exists'         => 'Bunday ID ga ega korxona mavjud emas',
            'passport_number.required'  => 'Passport nomeri talab qilinadi',
            'passport_number.min'       => 'Passport nomeri 9 xonadan kam bolmasligi kerak',
            'phone_number.required' => 'tel. raqami kiritilishi shart',
            'phone_number.unique'   => 'Ushbu tel. raqami tizimda allaqachon mavjud',
            'phone_number.regex'    => 'tel. raqamini togri formatda kiriting'
        ];
    }
}
