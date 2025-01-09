<?php

namespace App\Observers;

use App\EmployeeWage;

class EmployeeWageObserver
{
    /**
     * Handle the employee wage "created" event.
     */
    public function created(EmployeeWage $employeeWage)
    {
    }

    public function creating(EmployeeWage $employeeWage)
    {
    $employeeWage->alias = $employeeWage->employee->alias;
    }

    /**
     * Handle the employee wage "updated" event.
     */
    public function updated(EmployeeWage $employeeWage)
    {
        //
    }

    /**
     * Handle the employee wage "deleted" event.
     */
    public function deleted(EmployeeWage $employeeWage)
    {
        //
    }

    /**
     * Handle the employee wage "restored" event.
     */
    public function restored(EmployeeWage $employeeWage)
    {
        //
    }

    /**
     * Handle the employee wage "force deleted" event.
     */
    public function forceDeleted(EmployeeWage $employeeWage)
    {
        //
    }
}
