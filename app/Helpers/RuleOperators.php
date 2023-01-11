<?php

namespace App\Helpers;

class RuleOperators
{
    public function isEqual($field_name,$value): bool
    {
        if($field_name == $value){
            return true;
        }else{
            return  false;
        }
    }

    public function isGreaterThan($field_name,$value): bool
    {
        if($field_name > $value){
            return true;
        }else{
            return  false;
        }
    }
    public function isGreaterOrEqualTo($field_name,$value): bool
    {
        if($field_name >= $value){
            return true;
        }else{
            return  false;
        }
    }

    public function isLessThan($field_name,$value): bool
    {
        if($field_name < $value){
            return true;
        }else{
            return  false;
        }
    }
    public function isLessOrEqualTo($field_name,$value): bool
    {
        if($field_name <= $value){
            return true;
        }else{
            return  false;
        }
    }

}
