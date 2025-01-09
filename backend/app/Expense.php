<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{


    protected $fillable = [
        'cislo', 'datum', 'popis', 'text',
        'suma_zaklad', 'suma_dph', 'suma_celkom', 'sadzba_dph',
        'doklad', 'ucto', 'expense_category_id', 'expense_subcategory_id', 'account_id',
        'ownable_id', 'ownable_type',
        'reladeable_id', 'relateable_type',
        'user_id',
    ];

    public function expenseable()
    {
        return $this->morphTo();
    }

    public function relateable()
    {
        return $this->morphTo();
    }

    public function subcategory()
    {
        return $this->belongsTo('\App\ExpenseSubcategory');
    }

    public function account()
    {
        return $this->belongsTo('\App\Account');
    }
}
