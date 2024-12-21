<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartonBox extends Model
{
    use HasFactory;

    protected $fillable = ['barcode', 'status', 'packing_list_id'];

    public function packingList()
    {
        return $this->belongsTo(PackingList::class);
    }
}
