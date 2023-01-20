<?php

namespace App\Http\Controllers\Api;

use App\Models\Rule;
use Exception;
use Illuminate\Http\Request;
use App\Helpers\RuleOperators;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use NXP\MathExecutor;

class RulesController extends Controller
{
    public $string = " ";

    public function createRule(Request $request){ 
        $validator = Validator::make($request->all(),[
            'code'=> 'required|string|unique:monitor_rules,code',
            'title'=> 'required|string',
            'target_object'=> 'required|string|in:CUSTOMER,TRANSACTION',
            'assessment_type'=> 'required|string|in:ONLINE,RETROSPECTIVE',
            'data'=> 'required',
        ]);

        try {
            if($validator->fails()){
                // return response($validator->messages());
                return $this->errorResponse($validator->messages(),400);
            }
    
            $rule_array = [
                'code'=> $request->post('code'),
                'title'=> $request->post('title'),
                'target_object'=> $request->post('target_object'),
                'assessment_type'=> $request->post('assessment_type'),
                'data'=> json_encode($request->post('data')),
                'is_enabled'=> 1,
            ];
    
            $this->validateRuleData($request->post('data'));
    
            $result = Rule::create($rule_array);
    
            return $this->successResponse($result,'rule created successfully');
        } catch (Exception $e) {
            // return $this->errorResponse('Some Error Occured', 500);
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function validateRuleData($ruleData){
        $rules = $ruleData['rules'];
        $valid_fields = ['amount','source_country','destination_country'];
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

    public function decodeRule($ruleData, $transactionData)
    {
        $rules = $ruleData['rules'];
        $condition = $ruleData['condition'];

        for ($i = 0; $i < count($rules); $i++) {
            $item = $rules[$i];
            // print_r($item);

            if (!array_key_exists('rules', $item)) {
                $ruleOperators = new RuleOperators();
                $res = $ruleOperators->{$item['operator']}($transactionData[$item['field']], $item['value']);
                $this->string .= "(". $res .")";

                if ($i < count($rules) - 1) {
                    $this->string .= $condition;
                }
            } else {
                $this->string .= "(";
                $this->decodeRule($item, $transactionData);
                $this->string .= ")";
                if ($i < count($rules) - 1) {
                    $this->string .=  $condition;
                }
            }
        }
        return $this->string;
    }

    // public function customEval($statement, $final_response=[], $final_response_new=[]){
    //     print_r($statement);
    //     for($i=0; $i<count($statement); $i++){
    //         $condition = $statement[$i];
    //         // print_r($condition);
    //         switch ($condition) {
    //             case '(0&&1)':$final_response[] = 0;
    //                 break;
    //             case '(1&&0)':$final_response[] = 0;
    //                 break;
    //             case '(1||0)':$final_response[] = 1;
    //                 break;
    //             case '(0||1)':$final_response[] = 1;
    //                 break;
    //             case '(0||0)':$final_response[] = 0;
    //                 break;
    //             case '(0&&0)':$final_response[] = 0;
    //                 break;
    //             case '(1&&1)':$final_response[] = 1;
    //                 break;
    //             case '(1||1)':$final_response[] = 1;
    //             break;
    //             case 1:$final_response[] = 1;
    //             break;
    //             case 0:$final_response[] = 0;
    //             break;
    //             case '&&':$final_response[] = '&&';
    //                 break;
    //             case '||':$final_response[] = '||';
    //                 break;
    //         }
    //     }

    //     foreach (array_chunk($final_response, 3) as $value) {
    //         if(count($final_response) >= 3){
    //             $string = "({$value[0]}{$value[1]}{$value[2]})";
    //             $final_response_new[] = $string;
    //             // dd($final_response_new);
    //             $this->custom_eval($final_response_new);
    //         }else{
    //             // $string = "({$value[0]}{$value[1]}{$value[2]})";
    //             // $final_response_new[] = $string;
    //         }
    //     }
        
    //     dd($final_response[0]);

    // }
}
