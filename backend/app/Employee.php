<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'meno', 'priezvisko', 'titul', 'alias',
        'zaradenie', 'poznamka', 'aktivny', 'user_id'
    ];

    protected $guarded = [];

    protected $casts = [
        'aktivny' => 'boolean',
    ];

    protected $appends = [
        'full_name'
    ];


    public function extra_work()
    {

        return $this->hasMany(\App\ExtraWork::class);
    }

    public function jobs()
    {

        return $this->hasMany(\App\Job::class);
    }

    public function workhours()
    {

        return $this->hasMany(\App\Workhour::class);
    }

    public function accounts()
    {

        return $this->hasMany(\App\Account::class);
    }

    public function incomes()
    {
        return $this->morphMany(\App\Income::class, 'incomeable');
    }

    public function expenses()
    {
        return $this->morphMany(\App\Expense::class, 'expenseable');
    }

    // public function comments()
    // {

    //     return $this->hasMany(\App\Comment::class);
    // }

    public function wages()
    {

        return $this->hasMany('\App\EmployeeWage');
    }

    public function zarobene($querry)
    {
        $zarobok = App\Workhour::where('employee_id', $querry->id)->sum('mzda');

        return $zarobok;
    }

    public function scopeActive($query)
    {

        return $query->where('aktivny', 1);
    }

    public function getFullNameAttribute()
    {
        return   $this->meno . ' ' . $this->priezvisko . ' ' . $this->titul;
    }
}
