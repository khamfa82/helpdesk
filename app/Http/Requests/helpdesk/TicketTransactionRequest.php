<?php

namespace App\Http\Requests\helpdesk;

use Illuminate\Foundation\Http\FormRequest;

class TicketTransactionRequest extends FormRequest
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
            'ticket_id'            => 'required',
            'initiator_id'         => 'required',
            'assigned_to'          => 'required',
            'transaction_status'   => 'required',
        ];
    }
}
