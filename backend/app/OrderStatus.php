<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $fillable = [
        'nazov',
        'popis',
        'icon',
        'color',
        'color_text',
    ];

    public function orders()
    {

        return $this->hasMany(App\Order::class);
    }
}
