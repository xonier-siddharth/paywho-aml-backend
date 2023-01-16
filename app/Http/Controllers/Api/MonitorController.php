<?php

namespace App\Http\Controllers\Api;

use App\Models\Rule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\MonitorTransactionEvent;
use Illuminate\Support\Facades\Validator;

class MonitorController extends Controller
{
    public function monitor_transaction(Request $request)
    {
//        dd($request);
        $validator = Validator::make($request->all(), [
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
        ]);

        if ($validator->fails()) {
            return response($validator->messages());
        }

        $transaction_array = [
            'communication_number'=> $request->communication_number,
            'paywho_reference_id'=> $request->reference_id,
            'customer_id'=> $request->customer_id,
            'customer_type'=> $request->customer_type,
            'amount'=> $request->amount,
            'source_country'=> $request->source_country,
            'destination_country'=> $request->destination_country,
            'source_currency'=> $request->source_currency,
            'destination_currency'=> $request->destination_currency,
            'payment_mode'=> $request->payment_mode,
            'sender_ip_address'=> $request->ip_address,
            'payment_description'=> $request->payment_description,

            'sender_first_name'=> $request->sender['first_name'],
            'sender_last_name'=> $request->sender['last_name'],
            'sender_bic'=> $request->sender['bic'],
            'sender_bank_title'=> $request->sender['bank_title'],
            'sender_account_number'=> $request->sender['account_number'],

            'receiver_first_name'=> $request->receiver['first_name'],
            'receiver_last_name'=> $request->receiver['last_name'],
            'receiver_bic'=> $request->receiver['bic'],
            'receiver_bank_title'=> $request->receiver['bank_title'],
            'receiver_account_number'=> $request->receiver['account_number'],
        ];

        $rules = Rule::first();

        event(new MonitorTransactionEvent($transaction_array, $rules));
        // MonitorTransactionEvent::dispatch($transaction_array, $rules);

        // dd($transaction_array);

    }
}
