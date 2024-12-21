<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackingList extends Model
{
    use HasFactory;

    protected $fillable = ['customer_name', 'total_cartons', 'rule_id', 'customer_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function rule()
    {
        return $this->belongsTo(Rule::class);
    }

    public function cartonBoxes()
    {
        return $this->hasMany(CartonBox::class);
    }
}
