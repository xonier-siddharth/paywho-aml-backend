<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Rule;
use NXP\MathExecutor;
use Illuminate\Http\Request;
use App\Helpers\RuleOperators;
use App\Helpers\AggregatorFunctions;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RulesController extends Controller
{
    public $string = " ";
    private $aggregatorFuntions, $ruleOperators, $executor;

    public function __construct(){
        $this->aggregatorFuntions = new AggregatorFunctions();
        $this->ruleOperators = new RuleOperators();
        $this->executor = new MathExecutor();
    }

    public function createRule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'target_object' => 'required|string|in:CUSTOMER,TRANSACTION',
            'assessment_type' => 'required|string|in:ONLINE,RETROSPECTIVE',
            'action_type' => 'required|string|in:SCORE,STATE',
            'data' => 'required',
        ]);

        try {
            if ($validator->fails()) {
                // return response($validator->messages());
                return $this->errorResponse($validator->messages(), 400);
            }

            $rule_array = [
                'title' => $request->title,
                'description' => $request->description,
                'target_object' => $request->target_object,
                'assessment_type' => $request->assessment_type,
                'action_type' => $request->action_type,
                'state' => $request->state,
                'score' => $request->score,
                'data' => json_encode($request->data),
                'is_enabled' => 1,
            ];

            // $this->validateRuleData($request->post('data'));

            $result = Rule::create($rule_array);

            return $this->successResponse($result, 'rule created successfully');
        } catch (Exception $e) {
            // return $this->errorResponse('Some Error Occured', 500);
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function validateRuleData($ruleData)
    {
        $rules = $ruleData['rules'];
        $valid_fields = ['amount', 'source_country', 'destination_country'];
        $valid_operators = ['equalTo', 'greaterThan', 'greaterThanOrEqualTo', 'lessThan', 'lessThanOrEqualTo'];

        for ($i = 0; $i < count($rules); $i++) {
            $item = $rules[$i];

            if (!array_key_exists('rules', $item)) {
                if (!in_array($item['field'], $valid_fields) || !in_array($item['operator'], $valid_operators)) {
                    throw new \ErrorException('Invalid field name or operator choosen');
                }
            } else {
                $this->validateRuleData($item);
            }
        }
    }

    public function evaluate_rule($ruleData, $transactionData)
    {
        $condition = $ruleData['operator'];
        $rules = $ruleData['operands'];

        for ($i = 0; $i < count($rules); $i++) {
            $rule = $rules[$i];

            // if rule contents only single element
            if ($rule['type'] == 'rule') {
                $item = $rule['elements'];

                // if rule_parameter_type is function type
                if($item['rule_parameter_type'] == 'function_type'){
                    // $abc = $this->aggregatorFuntions->{$item['aggregator_function']}();
                    // $res = $this->ruleOperators->{$item['comp']}($abc, $item['value']);
                    $this->string .= "(" . 1 . ")";
                }

                // if rule_parameter_type is field type
                if($item['rule_parameter_type'] == 'field_type')
                {
                    $res = $this->ruleOperators->{$item['comp']}($transactionData[$item['field']], $item['value']);
                    $this->string .= "(" . $res . ")";
                }
            }

            // if rule contents nested rules
            if($rule['type'] == 'rule-group'){
                $this->string .= "(";
                $this->evaluate_rule($rule['children'], $transactionData);
                $this->string .= ")";
            }

            // add the main logical operator
            if ($i < count($rules) - 1) {
                $this->string .= $condition;
            }
        }
        return $this->string;
    }

    public function logical_expression(){
        
    }

    // public function decodeRule($ruleData, $transactionData)
    // {
    //     $rules = $ruleData['rules'];
    //     $condition = $ruleData['condition'];

    //     for ($i = 0; $i < count($rules); $i++) {
    //         $item = $rules[$i];

    //         if (!array_key_exists('rules', $item)) {
    //             $ruleOperators = new RuleOperators();
    //             $res = $ruleOperators->{$item['operator']}($transactionData[$item['field']], $item['value']);
    //             $this->string .= "(". $res .")";

    //             if ($i < count($rules) - 1) {
    //                 $this->string .= $condition;
    //             }
    //         } else {
    //             $this->string .= "(";
    //             $this->decodeRule($item, $transactionData);
    //             $this->string .= ")";
    //             if ($i < count($rules) - 1) {
    //                 $this->string .=  $condition;
    //             }
    //         }
    //     }
    //     return $this->string;
    // }

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
