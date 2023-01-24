<?php

namespace App\Http\Controllers;

use App\Models\RemittanceExchangeRate;
use App\Models\Rule;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AMLRuleController extends Controller
{
    public function create_rule(Request $request){
        $rules = "";
        foreach ($request->post('rule_data') as $item) {
            $rules .= "->where('{$item['field_name']}','{$item['operator']}','{$item['field_value']}')";
        }
        $rule_array = [
            'rule_code'=> $request->post('rule_code'),
            'rule_title'=> $request->post('rule_title'),
            'target_object'=> $request->post('target_object'),
            'assessment_type'=> $request->post('assessment_type'),
            'rule_data'=> json_encode($request->post('rule_data')),
            'enabled'=> $request->post('enabled'),
        ];

        $result = Rule::create($rule_array);

        return 'done';
    }

    public function evaluate_operation(Request $request){
        $rules = Rule::where('target_object','Operation')->where('enabled',1)->select('rule_data')->get();

        $transaction = new Transaction();

        $query = "";
        foreach ($rules as $rule) {
            $query .= "{$rule->rule_data}";
        }

        return $query;

        // return $res;
    }
}
