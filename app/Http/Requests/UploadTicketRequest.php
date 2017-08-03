<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadTicketRequest extends FormRequest
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
    public function messages(){
        return [
            'ticket.required' => 'Choose the file to be uploaded',
            'ticket.mimetypes' => 'The ticket must be a scanned pdf of the attested ticket'
        ];
    }
    public function rules()
    {
        return [
            'ticket' => 'required|mimetypes:application/pdf'
        ];
    }
}
