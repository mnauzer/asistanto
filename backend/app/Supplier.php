<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'meno', 'priezvisko', 'titul', 'alias',
         'poznamka', 'firma_nazov', 'aktivny', 'user_id', 'fo'
    ];

    protected $guarded = [];

    protected $casts = [
        'aktivny' => 'boolean',
    ];

    protected $appends = [
        'full_name'
    ];



    public function incomes()
    {
        return $this->morphMany(\App\Income::class, 'incomeable');
    }

    public function expenses()
    {
        return $this->morphMany(\App\Expense::class, 'expenseable');
    }
  
   

    public function scopeActive($query)
    {

        return $query->where('aktivny', 1);
    }

    public function getFullNameAttribute()
    {
        return  $this->meno . ' ' . $this->priezvisko .' '. $this->titul;
    }
}
