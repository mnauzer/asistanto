<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Job extends Model
{
    //
    protected $fillable = ['employee_id', 'datum', 'zaciatok', 'koniec', 'client_id', 'popis', 'order_id', 'user_id'];

    protected $dates = [
        'datum', 'created_at', 'updatet_at', 'deleted_at'
    ];

    protected $appends = [
        'zakazka'
    ];

    public function extra_work()
    {
        return $this->belongsTo(\App\ExtraWork::class);
    }

    public function employee()
    {
        return $this->belongsTo(\App\Employee::class);
    }

    public function order()
    {
        return $this->belongsTo(\App\Order::class);
    }

    public function getDates()
    {
        return ['deleted_at', 'created_at', 'updated_at', 'datum'];
    }

    public function job_description()
    {
        return $this->hasOne(\App\JobDescription::class);
    }

    public function getJobPopisAttribute()
    {
        $date = strtotime($datum);
        //dd($date);

        $result = \App\JobDescription::where('job_id', 'like', $job && 'datum', '=', $datum);
        return $result;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'A title is required',
            'body.required'  => 'A message is required',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'email' => 'email address',
        ];
    }

    public function getZakazkaAttribute()
    {

        if ($this->order) {
            $zakazka = $this->order->cislo
                . ' '
                . $this->order->alias
                . ' '
                . $this->order->nazov;

            return $zakazka;
        }
    }

    //  public function setDatumAttribute($value)
    //  {
    //      $this->attributes['datum'] = Carbon::createFromFormat('d.m.Y', $value)->format('Y-m-d');
    //  }

    //     public function getDatumAttribute($value)
    //  {
    //     return $this->attributes['datum'] = Carbon::createFromFormat('Y-m-d', $value)->format('d.m.Y');
    //  }

    //  public function getZaciatokAttribute($value)
    //  {
    //      return $this->attributes['zaciatok'] = Carbon::createFromFormat('H:i:s', $value)->format('G:i');
    //  }

    //  public function getKoniecAttribute($value)
    //  {
    //      return $this->attributes['koniec'] = Carbon::createFromFormat('H:i:s', $value)->format('G:i');
    //  }


}
