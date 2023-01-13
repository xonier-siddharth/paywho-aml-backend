<?php

namespace App\Helpers;

class RuleOperators
{
    public function equalTo($field_name,$value): bool
    {
        if($field_name == $value){
            return true;
        }else{
            return  false;
        }
    }

    public function greaterThan($field_name,$value): bool
    {
        if($field_name > $value){
            return true;
        }else{
            return  false;
        }
    }

    public function greaterThanOrEqualTo($field_name,$value): bool
    {
        if($field_name >= $value){
            return true;
        }else{
            return  false;
        }
    }

    public function lessThan($field_name,$value): bool
    {
        if($field_name < $value){
            return true;
        }else{
            return  false;
        }
    }
    public function lessThanOrEqualTo($field_name,$value): bool
    {
        if($field_name <= $value){
            return true;
        }else{
            return  false;
        }
    }

}
