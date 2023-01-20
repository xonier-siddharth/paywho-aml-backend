<?php

namespace App\Services;

use NXP\MathExecutor;
use App\Http\Controllers\Api\RulesController;
 
class TransactionService {
 
    public function validate_transaction($transaction_data,$rules)
    {
        $executor = new MathExecutor();
        $ruleClass = new RulesController();
        $score = [];
        foreach($rules as $rule){
            $rule_data = json_decode($rule['data'], true);
            $eval = $ruleClass->decodeRule($rule_data, $transaction_data);  //(0||1) && (0||1)
            $ruleClass->string = "";
            $score[] = $executor->execute($eval);
        }

        return $score;
    }
}

?>