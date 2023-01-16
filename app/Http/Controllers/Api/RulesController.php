<?php

namespace App\Http\Controllers\Api;

use App\Models\Rule;
use Illuminate\Http\Request;
use App\Helpers\RuleOperators;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class RulesController extends Controller
{
    private $scores = [];

    public function createRule(Request $request){
        $validator = Validator::make($request->all(),[
            'code'=> 'required|string|unique:monitor_rules,code',
            'title'=> 'required|string',
            'target_object'=> 'required|string|in:CUSTOMER,TRANSACTION',
            'assessment_type'=> 'required|string|in:ONLINE,RETROSPECTIVE',
            'data'=> 'required',
        ]);

        if($validator->fails()){
            return response($validator->messages());
        }

        $rule_array = [
            'code'=> $request->post('code'),
            'title'=> $request->post('title'),
            'target_object'=> $request->post('target_object'),
            'assessment_type'=> $request->post('assessment_type'),
            'data'=> json_encode($request->post('data')),
        ];

        $this->validateRuleData($request->post('data'));

        $result = Rule::create($rule_array);

        return 'done';
    }

    public function validateRuleData($ruleData){
        $rules = $ruleData['rules'];
        $valid_fields = ['amount','source_country'];
        $valid_operators = ['equalTo','greaterThan','greaterThanOrEqualTo','lessThan','lessThanOrEqualTo'];

        for ($i = 0; $i < count($rules); $i++) {
            $item = $rules[$i];

            if (!array_key_exists('rules', $item)) {
                if(!in_array($item['field'], $valid_fields) || !in_array($item['operator'], $valid_operators)){
                    throw new \ErrorException('Invalid field name or operator choosen');
                }
            } else {
                $this->validateRuleData($item);
            }
        }
    }

    public function validateTransaction(Request $request)
    {
        $transactionData = DB::table('monitor_transactions')->first();
        $transactionData = (array) $transactionData;

        $ruleData = json_decode(file_get_contents(storage_path() . "/json_files/test_rule.json"), true);

        $eval = $this->decodeQuery($ruleData, $transactionData);

        return eval(' return ' . $eval . ' ; ');

        // return ($eval);
        // dd($this->scores);
    }

    public function decodeQuery($ruleData, $transactionData)
    {
        $rules = $ruleData['rules'];
        $condition = $ruleData['condition'];
        global $string;

        for ($i = 0; $i < count($rules); $i++) {
            $item = $rules[$i];

            if (!array_key_exists('rules', $item)) {
                $ruleOperators = new RuleOperators();
                $res = $ruleOperators->{$item['operator']}($transactionData[$item['field']], $item['value']);

                $string .= "('" . $res . "')";

                if ($i < count($rules) - 1) {
                    $string .= " " . $condition . " ";
                }
            } else {
                $string .= "(";
                $this->decodeQuery($item, $transactionData);
                $string .= ")";
                if ($i < count($rules) - 1) {
                    $string .= " " . $condition . " ";
                }
            }
        }

        return $string;
    }
}
