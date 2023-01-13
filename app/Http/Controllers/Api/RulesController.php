<?php

namespace App\Http\Controllers\Api;

use App\Helpers\RuleOperators;
use App\Http\Controllers\Controller;
use App\Models\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RulesController extends Controller
{

    private $string = "";
    private $scores = [];

    public function getRule(Request $request){
        $transactionData = DB::table('monitor_transactions')->first();
        $transactionData = (array) $transactionData;

        $ruleData = json_decode(file_get_contents(storage_path()."/json_files/test_rule.json"), true);

        $this->decodeQuery($ruleData['rules'], $ruleData['condition'], $transactionData);
//        $this->decodeQuery1($ruleData['rules'], $ruleData['condition'], $transactionData);

//        return eval(' return '.$this->string.' ; ');

        return ($this->string);
        dd ($this->scores);
    }

    public function  decodeQuery1($rules, $condition, $transactionData) {
        for ($i = 0; $i < count($rules); $i++) {
            $item = $rules[$i];

            if(!isset($item['rules'])){
//                $this->string .= "('". $transactionData[$item['field']] . "' ". $item['operator'] ." '". $item['value'] . "')";
//                $this->string .= "( {$item['operator']}('{$transactionData[$item['field']]}','{$item['value']}') )";
//
//                if($i != count($rules)-1){
//                    $this->string .= $condition;
//                }

                $ruleOperators = new RuleOperators();
                $res = $ruleOperators->{$item['operator']}($transactionData[$item['field']], $item['value']);
                if($res){
                    $this->scores[] = 1;
                }else{
                    $this->scores[] = 0;
                }

            }else{
//                $this->string .= "(";
                $condition_new = $item['condition'];
                $rule = $item['rules'];
                $this->decodeQuery1($rule, $condition_new, $transactionData);
//                $this->string .= ")";
            }
        }
    }

    public function  decodeQuery($rules, $condition, $transactionData) {
        for ($i = 0; $i < count($rules); $i++) {
            $item = $rules[$i];

            if(!isset($item['rules'])){
                $this->string .= "('". $transactionData[$item['field']] . "' ". $item['operator'] ." '". $item['value'] . "')";

                if($i < count($rules)-1){
                    $this->string .= $condition;
                }
            }else{
                $this->string .= "(";
                $condition_new = $item['condition'];
                $rule = $item['rules'];
                $this->decodeQuery($rule, $condition_new, $transactionData);
                $this->string .= ")";
            }
        }
    }
}





