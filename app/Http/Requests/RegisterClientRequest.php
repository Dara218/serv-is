<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterClientRequest extends FormRequest
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
        return [
            'fullname' => 'required',
            'username' => [
                'required',
                'unique:agents,username',
                'min:4',
                'max:20'
            ],
            'email_address' => [
                'email',
                'required',
                'unique:agents,email_address',
                'min:4',
                'max:20'
            ],
            'contact_no' => 'required|numeric|unique:agents,contact_no,',
            'password' => [
                'required',
                'min:8',              // minimum length of 8 characters
                'max:255',            // maximum length of 255 characters
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain at least one special character
            ],
            'address' => 'required',
            'region' => 'required',
            'photo_id' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'nbi_clearance' => 'required|mimes:jpeg,png,jpg,txt,pdf,docs|max:2048',
            'police_clearance' => 'required|mimes:jpeg,png,jpg,txt,pdf,docs|max:2048',
            'birth_certificate' => 'required|mimes:jpeg,png,jpg,txt,pdf,docs|max:2048',
            'cert_of_employment' => 'required|mimes:jpeg,png,jpg,txt,pdf,docs|max:2048',
            'other_valid_id' => 'required|mimes:jpeg,png,jpg,txt,pdf,docs|max:2048',
        ];
    }
}
