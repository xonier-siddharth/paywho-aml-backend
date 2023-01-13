<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;
    protected $table = "monitor_rules";

    protected $fillable = [
        'code', 'title', 'target_object', 'assessment_type', 'data', 'is_enabled'
    ];
}
