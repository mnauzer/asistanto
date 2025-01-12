<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    protected $fillable = [
        'person_id',
        'position',
        'hire_date',
        'termination_date'
    ];

    protected $casts = [
        'hire_date' => 'date',
        'termination_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function rates()
    {
        return $this->hasMany(EmployeeRate::class);
    }

    public function attendanceRecords()
    {
        return $this->hasMany(AttendanceRecord::class);
    }
}
