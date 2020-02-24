<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    protected $fillable = [
        'product_id','bar_code', 'unit_id', 'cost_price', 'sell_price', 'remark',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    // has 别人有你的id   belong 你有别人的id
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function scopeWithOrder($query, $order, $order_type = 'desc')
    {
        switch ($order) {
            case 'price':
                $query->orderBy('sell_price', $order_type);
                break;

            default:
                $query->orderBy('created_at', $order_type);
                break;
        }
        return $query->with('product.category', 'unit');
    }

}
