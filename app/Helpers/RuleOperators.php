<?php

namespace App\Helpers;

class RuleOperators
{
    public function equalTo($field_name,$value): int
    {
        if($field_name == $value){
            return 1;
        }else{
            return  0;
        }
    }

    public function greaterThan($field_name,$value): int
    {
        if($field_name > $value){
            return 1;
        }else{
            return  0;
        }
    }

    public function greaterThanOrEqualTo($field_name,$value): int
    {
        if($field_name >= $value){
            return 1;
        }else{
            return  0;
        }
    }

    public function lessThan($field_name,$value): int
    {
        if($field_name < $value){
            return 1;
        }else{
            return  0;
        }
    }
    public function lessThanOrEqualTo($field_name,$value): int
    {
        if($field_name <= $value){
            return 1;
        }else{
            return  0;
        }
    }

}
