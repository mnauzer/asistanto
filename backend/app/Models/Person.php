<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'nick',
        'title',
        'first_name',
        'last_name',
        'company_name',
        'ico',
        'dic',
        'is_vat_payer',
        'is_company',
        'is_active',
        'place_id',
        'email',
        'phone'
    ];

    protected $casts = [
        'is_vat_payer' => 'boolean',
        'is_company' => 'boolean',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }
}




class InventoryItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'category',
        'description',
        'unit',
        'purchase_price',
        'selling_price',
        'vat_rate',
        'minimum_stock',
        'current_stock',
        'is_active'
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'vat_rate' => 'decimal:2',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];
}
