<?php

namespace App\Http\Requests;

use App\Http\Controllers\Traits\ResponseAble;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UserUpdateRequest extends FormRequest
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
            'id'        => 'required|exists:users,id',
            'name'      => 'required|min:2',
            'email'     => 'required|email|unique:users,email,'.$this->id,
            'role'      => 'required|in:admin,company'
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
            'id.required'       => 'User ID kiritilishi shart',
            'id.exists'         => 'Bunday ID ga ega user mavjud emas',
            'name.required'     => 'User name kiritilishi shart',
            'name.min'          => 'User name 2 ta harfdan kam bolmasligi kerak',
            'email.required'    => 'Email kiritilishi shart',
            'email.unique'      => 'Ushbu email allaqachon tizimda mavjud',
            'email.email'       => 'Email adresingizni togri formatta kiriting',
            'role.in'           => 'Role quyidagilardan biri bolishi lozim: admin, company',
            'role.required'     => 'Role albatta kiritilishi kerak',
        ];
    }
}
