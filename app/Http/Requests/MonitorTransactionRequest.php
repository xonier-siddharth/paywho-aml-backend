<?php

namespace App\Http\Requests;

use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class MonitorTransactionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'communication_number' => 'required|string|unique:monitor_transactions,communication_number',
            'customer_type' => 'required|string|in:IND,ORG',
            'amount' => 'required',
            'financial_flow_direction' => 'required|string|in:INCOMING,OUTGOING',
            'source_country' => 'required|string',
            'destination_country' => 'required|string',
            'source_currency' => 'required|string',
            'destination_currency' => 'required|string',
            'ip_address' => 'required|string',
            'payment_description' => 'required|string',
            'payment_mode' => 'required|string',
            'sender.account_number' => 'required|string',
            'sender.first_name' => 'required|string',
            'sender.last_name' => 'required|string',
            'sender.bic' => 'required|string',
            'receiver.account_number' => 'required|string',
            'receiver.first_name' => 'required|string',
            'receiver.last_name' => 'required|string',
            'receiver.bic' => 'required|string',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = new Response(['error' => $validator->errors()], 400);
        throw new ValidationException($validator, $response);
    }
}
