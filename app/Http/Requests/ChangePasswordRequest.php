<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
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
            'old_password' => 'required|samePassword:' . Auth::user()->password,
            'new_password' => 'required|confirmed',
        ];
    }
    public function messages(){
        return [
            'new_password.confirmed' => 'Your passwords dont match'
        ];
    }
}
