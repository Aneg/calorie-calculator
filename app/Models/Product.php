<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * App\Models\Product
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Basket[] $baskets
 * @property-read \App\Models\User $user
 * @mixin \Eloquent
 */
class Product extends Model
{
    protected $fillable = [
        'id',
        'name',
        'hash',
        'protein',
        'fat',
        'carbohydrate',
        'calories',
        'created_at',
        'updated_at',
        'user_id',
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
    public function baskets()
    {
        return $this->belongsToMany(Basket::class, 'basket_items', 'product_id', 'basket_id');
    }

    public function toApi($options = [])
    {
        $options = Collection::make($options);
        $full  = $options->get('full', true);
        $user  = $options->get('user', false);
        $baskets  = $options->get('baskets', false);


        $data = [
            'id'   => $this->id,
            'name' => $this->name,
            'hash' => $this->hash,
            'protein' => $this->protein,
            'fat' => $this->fat,
            'carbohydrate' => $this->carbohydrate,
            'calories' => $this->calories,
        ];


        if ($user) {
            $user = $this->user->toApi(['full' => false]);
            $data = array_merge($data, ['user' => $user]);
        }

        if ($baskets) {
            $baskets = [];
            foreach ($this->baskets as $basket) {
                $baskets[] = $basket->toApi(['full' => false]);
            }
            $data = array_merge($data, ['baskets' => $baskets]);
        }

        if ($full) {
            $data = array_merge($data, [
                'created_at'  => $this->created_at->format('d.m.Y H:i:s'),
                'updated_at'  => $this->updated_at->format('d.m.Y H:i:s'),
            ]);
        }

        return $data;
    }
}
