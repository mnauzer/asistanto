<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public $table = 'accounts';

    protected $fillable = [
        'employee_id', 'typ', 'ucel', 'nazov', 'aktivny',
        'zostatok', 'prefix', 'suma_celkom', 'sadzba_dph',
        'doklad', 'ucto', 'icon', 'color', 'color_text'
    ];

    public function incomes()
    {
        return $this->hasMany('\App\Income');
    }

    public function expenses()
    {
        return $this->hasMany('\App\Expense');
    }

    public function employee()
    {
        return $this->belongsToMany('\App\Employee');
    }

}