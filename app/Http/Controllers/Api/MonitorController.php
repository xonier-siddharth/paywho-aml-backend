<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Rule;
use NXP\MathExecutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Events\MonitorTransactionEvent;
use App\Http\Controllers\Api\RulesController;
use App\Http\Requests\MonitorTransactionRequest;

class MonitorController extends Controller
{
    public function monitor_transaction_online(MonitorTransactionRequest $request)
    {
        try {
            $transaction_array = [
                'communication_number' => $request->communication_number,
                'paywho_reference_id' => $request->reference_id,
                'customer_id' => $request->customer_id,
                'customer_type' => $request->customer_type, 
                'amount' => $request->amount,
                'source_country' => $request->source_country,
                'destination_country' => $request->destination_country,
                'source_currency' => $request->source_currency,
                'destination_currency' => $request->destination_currency,
                'payment_mode' => $request->payment_mode,
                'sender_ip_address' => $request->ip_address,
                'payment_description' => $request->payment_description,
                'financial_flow_direction' => $request->financial_flow_direction,
    
                'sender_first_name' => $request->sender['first_name'],
                'sender_last_name' => $request->sender['last_name'],
                'sender_bic' => $request->sender['bic'],
                'sender_bank_title' => $request->sender['bank_title'],
                'sender_account_number' => $request->sender['account_number'],
    
                'receiver_first_name' => $request->receiver['first_name'],
                'receiver_last_name' => $request->receiver['last_name'],
                'receiver_bic' => $request->receiver['bic'],
                'receiver_bank_title' => $request->receiver['bank_title'],
                'receiver_account_number' => $request->receiver['account_number'],
            ];
    
            //get all rules, applicable for this assessment mod
            $rules = Rule::where('target_object', 'TRANSACTION')
                ->where('assessment_type', 'ONLINE')
                ->where('is_enabled', 1)->get();
            // dd($rules);

            $result = DB::table('monitor_transactions')->insertGetId($transaction_array);

            if ($result) {
                $transaction_array['id'] = $result;
                // event(new MonitorTransactionEvent($transaction_array, $rules));
                $result = $this->validate_transaction($transaction_array, $rules);
                return $this->successResponse($result,'ACCEPTED');
            }else{
                return $this->errorResponse('REJECTED',500);
            }
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(),500);
        }
    }

    public function validate_transaction($transaction_data,$rules)
    {
        $executor = new MathExecutor();
        $ruleClass = new RulesController();
        $score = [];
        foreach($rules as $rule){
            $rule_data = json_decode($rule['data'], true);
            $eval = $ruleClass->decodeRule($rule_data, $transaction_data);  //(0||1) && (0||1)
            $ruleClass->string = "";
            $score[] = [
                'rule_code' => $rule['code'],
                'result' => $executor->execute($eval)
            ];
        }

        return $score;
    }
}
