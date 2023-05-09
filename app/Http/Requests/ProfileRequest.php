<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $userId = Auth::user()->id;
        return [
            'fullname' => 'required',
            'username' => [
                'required',
                'unique:users,username,'.$userId,
                'min:4',
                'max:20'
            ],
            'email_address' => [
                'email',
                'unique:users,email_address,'.$userId,
                'required',
                'min:4',
                'max:50'
            ],
            'contact_no' => 'required|numeric','unique:users,contact_no,'.$userId,
            'password' => [
                'required',
                'min:8',              // minimum length of 8 characters
                'max:255',            // maximum length of 255 characters
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain at least one special character
            ],
            // 'address' => 'required',
            'region' => 'required',
        ];
    }
}
