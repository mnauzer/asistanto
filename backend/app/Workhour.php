<?php

namespace App;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class Workhour extends Model
{
    //
    public $table = 'workhours';

    protected $fillable = ['employee_id', 'datum', 'zaciatok', 'koniec', 'poznamka', 'user_id'];

    protected $dates = [
        'created_at', 'updatet_at', 'deleted_at'
    ];

    function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function getMzdyAttribute($id)
    {
        if ($id) {
            $mzdy = Workhour::where('id', $id)->get()->sum('mzda');
            return $mzdy;
        } else {
            $mzdy = Workhour::all()->sum('mzda');
            return $mzdy;
        }
    }

    public function employee()
    {
        return $this->belongsTo(\App\Employee::class);
    }

  

    //     public function getZaciatokAttribute($value)
    // {
    //     return $this->attributes['zaciatok'] = Carbon::createFromFormat('H:i:s', $value)->format('G:i');
    // }

    //     public function getKoniecAttribute($value)
    // {
    //     return $this->attributes['koniec'] = Carbon::createFromFormat('H:i:s', $value)->format('G:i');
    // }
     
    // public function setZaciatokAttribute($value)
    // {
    //     return $this->attributes['zaciatok'] = Carbon::createFromFormat('H:i:s', $value)->format('G:i');
    // }

    //     public function setKoniecAttribute($value)
    // {
    //     return $this->attributes['koniec'] = Carbon::createFromFormat('H:i:s', $value)->format('G:i');
    // }

    // public function getDatumAttribute($value)
    // {
    //     return $this->attributes['datum'] =  Carbon::createFromFormat('Y-m-d', $value)->format('d.m.Y');
    // }

 
}
