<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'cislo' , 'nazov', 'alias',
        'popis', 'datum','zacatie','ukoncenie',
        'sadzba_dph','suma_zaklad','suma_dph','suma_celkom',
        'poznamka',
        'miesto','vzdialenost',
        'uctovanie_typ','uctovanie_dopravy',
        'customer_id', 'type_id','status_id',
        'user_id',
    ];

    public function incomes()
    {
        return $this->morphMany(\App\Income::class, 'relateable');
    }


    public function expenses()
    {
        return $this->morphMany(\App\Expense::class, 'relateable');
    }
   

        public function customer()
    {

        return $this->belongsTo(\App\Customer::class);
    }

        public function type()
    {

        return $this->belongsTo(\App\OrderType::class);
    }

        public function status()
    {

        return $this->belongsTo(\App\OrderStatus::class);
    }

        public function jobs()
    {

        return $this->hasMany(\App\Job::class);
    }

        public function extraJobs()
    {

        return $this->hasMany(\App\ExtraJob::class);
    }


}
