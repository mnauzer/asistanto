<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderType extends Model
{
    protected $fillable = [
        'nazov',
        'popis',
        'prefix',
        'icon',
        'color',
        'color_text',
    ];

    public function orders()
    {

        return $this->hasMany(App\Order::class);
    }
}
