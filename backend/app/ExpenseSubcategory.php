<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseSubcategory extends Model
{
    protected $fillable = [
        'nazov', 'text', 'category_id', 'icon', 'color','color_text','model', 
    ];

    public function category()
    {
        return $this->belongsTo('\App\ExpenseCategory');
    }

    public function expenses()
    {
        return $this->hasMany('\App\Expense','subcategory_id');
    }
}
