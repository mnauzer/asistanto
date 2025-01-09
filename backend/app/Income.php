<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    public $table = 'incomes';

    protected $fillable = [
        'cislo', 'datum', 'popis', 'text',
        'suma_zaklad', 'suma_dph', 'suma_celkom', 'sadzba_dph',
        'doklad', 'ucto', 'category_id', 'subcategory_id', 'account_id',
        'incomeable_id', 'incomeable_type',
        'reladed_id', 'related_type',
        'user_id'
    ];


    public function incomeable()
    {
        return $this->morphTo();
    }

    public function category()
    {
        return $this->belongsTo(\App\IncomeCategory::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(\App\IncomeSubcategory::class);
    }

       
}
