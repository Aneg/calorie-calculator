<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * App\Models\BascetItem
 *
 * @property-read \App\Models\Basket $basket
 * @property-read \App\Models\Product $product
 * @mixin \Eloquent
 */
class BasketItem extends Model
{
    protected $fillable = ['id', 'basket_id', 'product_id', 'created_at', 'updated_at', 'weight'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function basket()
    {
        return $this->belongsTo(Basket::class);
    }

    public function toApi($options = [])
    {
        $options = Collection::make($options);
        $full = $options->get('full', false);

        $data = [
            'id'        => $this->id,
            'productId' => $this->product_id,
            'basketId'  => $this->basket_id,
            'weight'    => $this->weight
        ];

        if ($full) {
            $data['protein'] = $this->product->protein * $this->weight / 100;
            $data['fat'] = $this->product->fat * $this->weight / 100;
            $data['carbohydrate'] = $this->product->carbohydrate * $this->weight / 100;
            $data['calories'] = $this->product->calories * $this->weight / 100;
        }

        return $data;
    }
}
