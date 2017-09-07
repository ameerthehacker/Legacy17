<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrizeRequest extends FormRequest
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
        $event_id = $this->route('event');        
        return [
            'first_prize' => 'required|exists:users,id|isParticipating:' . $event_id,
            'second_prize' => 'required|exists:users,id|isParticipating:' . $event_id,
            'third_prize' => 'required|exists:users,id|isParticipating:' . $event_id,            
        ];
    }
    public function messages()
    {
        return [
            'first_prize.exists' => 'The first prize user does not exist',
            'second_prize.exists' => 'The first prize user does not exist',
            'third_prize.exists' => 'The first prize user does not exist',            
        ];
    }
}
