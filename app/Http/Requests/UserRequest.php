<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
             'name' => 'required|string|max:100',
             
            'email' => $this->isMethod('post') 
             ? 'required|email|unique:users,email,'
             : 'nullable|email|unique:users,email,' .  $this->route('user')->id,

            'password' => $this->isMethod('post') 
                ? 'required|min:8|confirmed'   // required on create
                : 'nullable|min:8|confirmed',  // optional on update

        ];
    }
}
