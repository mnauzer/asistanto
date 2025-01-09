<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncomeCategory extends Model
{
    protected $fillable = [
        'nazov', 'text', 'icon', 'color', 'color_text', 'model', 'user_id'
    ];


    public function subcategories()
    {
        return $this->hasMany(\App\IncomeSubcategory::class);
    }

    public function incomes()
    {
        return $this->hasMany(\App\Income::class);
    }
}
