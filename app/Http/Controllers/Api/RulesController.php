<?php

namespace App\Http\Controllers\Api;

use App\Helpers\RuleOperators;
use App\Http\Controllers\Controller;
use App\Models\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RulesController extends Controller
{

    public function getRule(Request $request){
        $transactionData = DB::table('monitor_transactions')->first();

        $rules = Rule::first();
        $ruleData = json_decode($rules->data, true);

        $field_name=$ruleData[0]['field_name'];//amount
        $operator=$ruleData[0]['operator'];//operator
        $field_value=$ruleData[0]['field_value'];//200000

        if(!property_exists($transactionData, $field_name)){
           return "data missing validate and check again.";
        }

        $ruleOperators = new RuleOperators();
        return $ruleOperators->{$operator}($field_name, $field_value);
    }
}
