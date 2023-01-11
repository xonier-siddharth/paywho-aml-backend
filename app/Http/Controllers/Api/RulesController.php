<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RulesController extends Controller
{
    public function getRule(Request $request){
        $transactionData = DB::table('monitor_transactions')->first();
//        dd($transactionData);

        $rules = Rule::first();
        $ruleData = json_decode($rules->data, true);
//        dd($ruleData);

        $field_name=$ruleData[0]['field_name'];//amount

        if(!property_exists($transactionData, $field_name)){
           return "data missing validate and check again.";
        }

        $operator=$ruleData[0]['operator'];//operator
        $field_value=$ruleData[0]['field_value'];//200000

//        dd($field_name,$operator,$field_value);
        return $this->{$operator}($field_name, $field_value);
    }

    public function greaterThan($field_name,$value): bool
    {
        if($field_name > $value){
            return true;
        }else{
            return  false;
        }
    }
}
