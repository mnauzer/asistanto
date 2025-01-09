<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    protected $fillable = [
        'nazov', 'text', 'icon', 'color','color_text', 'model', 'user_id'
    ];


    public function subcategories()
    {
        return $this->hasMany('\App\ExpenseSubcategory','category_id');
    }

    public function expenses()
    {
    return $this->hasManyThrough('\App\Expense','\App\ExpenseSubcategory','category_id', 'subcategory_id');
    }

}
