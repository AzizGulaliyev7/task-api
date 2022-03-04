<?php

namespace App\Http\Requests;

use App\Company;
use App\Http\Controllers\Traits\ResponseAble;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CompanyUpdateRequest extends FormRequest
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
            'id'    => 'required|exists:companies,id',
            'name'  => 'required|min:2',
            'phone_number' => [
                'required',
                'unique:companies,phone_number,'.$this->id,
                'regex:/\+(9[976]\d|8[987530]\d|6[987]\d|5[90]\d|42\d|3[875]\d|2[98654321]\d|9[8543210]|8[6421]|6[6543210]|5[87654321]|4[987654310]|3[9643210]|2[70]|7|1)\d{1,14}$/'
            ]
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $id = $this->get('id', null);

            if ($id) {
                if (Company::where('id', $id)->exists()) {
                    $user = Auth::user();
                    if (($user->role == 'company') && !Company::where('id', $id)->where('user_id', $user->id)->exists()) {
                        $validator->errors()->add('id', "Company rolidagi foydalanuvchi oziga tegishli bolmaga korxonani malumotlarini taxrirlash mumkin emas!");
                    }
                } else {
                    $validator->errors()->add('id', "Korxona topilmadi!");
                }
            }
        });
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
            'id.required'   => 'Korxona ID si kiritilishi shart',
            'id.exists'     => 'Bunday ID ga ega korxona mavjud emas',
            'name.required' => 'Korxona nomi kiritilishi shart',
            'name.min'      => 'Korxona nomi kamida ikki harfdan iborat bolishi kerak',
            'phone_number.required' => 'tel. raqami kiritilishi shart',
            'phone_number.unique'   => 'Ushbu tel. raqami tizimda allaqachon mavjud',
            'phone_number.regex'    => 'tel. raqamini togri formatda kiriting'
        ];
    }
}
