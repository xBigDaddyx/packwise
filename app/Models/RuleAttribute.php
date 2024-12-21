<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuleAttribute extends Model
{
    use HasFactory;

    protected $fillable = ['rule_id', 'attribute_name', 'value', 'quantity'];

    public function rule()
    {
        return $this->belongsTo(Rule::class);
    }
}
