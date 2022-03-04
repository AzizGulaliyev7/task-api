<?php

namespace App\Http\Requests;

use App\Http\Controllers\Traits\ResponseAble;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UserCreateRequest extends FormRequest
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
            'name'      => 'required|min:2',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6',
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
            'password.required' => 'parolni kiriting',
            'password.min'      => 'parolning uzunligi kamida 6 xona bolishi kerak',
            'name.required'     => 'User name kiritilishi shart',
            'name.min'          => 'User name 2 ta harfdan kam bolmasligi kerak',
            'email.required'    => 'Email kiritilishi shart',
            'email.unique'      => 'Ushbu email allaqachon tizimda mavjud',
            'email.email'       => 'Email adresingizni togri formatta kiriting',
            'role.required'     => 'Role albatta kiritilishi kerak',
            'role.in'           => 'Role quyidagilardan biri bolishi lozim: admin, company'
        ];
    }
}
