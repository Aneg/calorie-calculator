<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function baskets()
    {
        return $this->hasMany(Basket::class);
    }

    /*
     * Helpers
     */
    public function toApi($options = [])
    {
        $options = Collection::make($options);
        $token = $options->get('token', false);

        $data = [
            'id'     => $this->id,
            'name'    => $this->name,
            'email'  => $this->email,
            'active' => (bool)$this->api_token,
        ];

        if($token) {
            $data['api_token'] = $this->api_token;
        }

        return $data;
    }
}
