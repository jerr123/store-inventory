<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRecord extends Model
{
    protected $fillable = [
        'sku_id', 'num', 'cost_price', 'sell_price',
    ];

    public function sku()
    {
        return $this->belongsTo(Sku::class);
    }
}
