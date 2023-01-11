<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RulesController extends Controller
{
    //

    public function getRule(Request $request,$transactionData){
        $ruleData = json_decode($request->getContent(), true);

        $field_name=$ruleData['data']['field_name'];//amount
        if!($transactionData contains $field_name){
           return data missing validate and check again.
        }
        $operator=$ruleData['data']['operator'];//operator
        $field_value=$ruleData['data']['field_value'];//200000

        eval($transactionData[$field_name].$operator.$field_value);



    }
}
