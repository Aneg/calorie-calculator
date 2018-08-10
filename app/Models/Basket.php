<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * App\Models\Basket
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read \App\Models\User $user
 * @mixin \Eloquent
 */
class Basket extends Model
{
    protected $fillable = [
        'id',
        'name',
        'hash',
        'created_at',
        'updated_at',
        'user_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'basket_items', 'basket_id', 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(BasketItem::class);
    }

    public function toApi($options = [])
    {
        $options = Collection::make($options);
        $full    = $options->get('full', false);
        $items   = $options->get('items', false);

        $data = [
            'id'   => $this->id,
            'name' => $this->name,
            'hash' => $this->hash,
        ];

        if ($full) {
            $data = array_merge($data, [
                'created_at'  => $this->created_at->format('d.m.Y H:i:s'),
                'updated_at'  => $this->updated_at->format('d.m.Y H:i:s'),
            ]);
        }

        if ($items) {
            $data['protein'] = 0;
            $data['fat'] = 0;
            $data['carbohydrate'] = 0;
            $data['calories'] = 0;
            /** @var BasketItem $item */
            foreach ($this->items as $item) {
                $item_data = $item->toApi(['full' => true]);
                $data['protein']      += (float)$item_data['protein'];
                $data['fat']          += (float)$item_data['fat'];
                $data['carbohydrate'] += (float)$item_data['carbohydrate'];
                $data['calories']     += (float)$item_data['calories'];

                $data['items'][] = $item_data;
            }
        }

        return $data;
    }
}
