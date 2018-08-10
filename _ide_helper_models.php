<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Basket
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read \App\Models\User $user
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BasketItem[] $items
 */
	class Basket extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BascetItem
 *
 * @property-read \App\Models\Basket $basket
 * @property-read \App\Models\Product $product
 * @mixin \Eloquent
 */
	class BasketItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Basket[] $baskets
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Basket[] $baskets
 * @property-read \App\Models\User $user
 * @mixin \Eloquent
 */
	class Product extends \Eloquent {}
}

