<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees'; // Tabuľka v DB

    protected $fillable = [
        'employee_number',
        'first_name',
        'last_name',
        'nickname',
        'position',
        'is_active',
        'address_id',
    ];

    /**
     * Relationship: Employee has many attendance records.
     */
    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'employee_id');
    }
}
