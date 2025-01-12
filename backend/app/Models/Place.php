<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Place extends Model
{
    protected $fillable = [
        'name',
        'street',
        'city',
        'postal_code',
        'country',
        'latitude',
        'longitude'
    ];

    protected $casts = [
        'latitude' => 'decimal:6',
        'longitude' => 'decimal:6'
    ];

    public function persons()
    {
        return $this->hasMany(Person::class);
    }
}
