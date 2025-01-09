<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeWage extends Model
{
      protected $fillable = [
        'alias', 'employee_id', 'platnost', 'sadzba', 'user_id'
    ];

    protected $guarded = [];

    protected $casts = [
    ];

    protected $appends = [
    ];

  public function employee()
    {

        return $this->belongsTo(\App\Employee::class);
    }
}
