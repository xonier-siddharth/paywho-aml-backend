<?php

namespace App\Http\Controllers\Api\V2;

class RulesController extends \App\Http\Controllers\Controller
{
    public function createRule(){
        return "working";
    }

    public function editRule($rule_id){
        return "rule_id".$rule_id;

    }

}
