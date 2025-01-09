<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncomeSubcategory extends Model
{
    //
    protected $fillable = [
        'nazov', 'text', 'category_id', 'icon', 'color', 'color_text','model', 
    ];

    protected $guarded = [];

    protected $casts = [];

    protected $appends = [];

           public function category()
    {

        return $this->belongsTo(\App\IncomeCategory::class);
    }
           public function incomes()
    {

        return $this->hasMany(\App\Income::class);
    }
}
