<?php

namespace App\Observers;

use App\Employee;

class EmployeeObserver
{
    /**
     * Handle the employee "created" event.
     */
    public function created(Employee $employee)
    {
    }

    public function creating(Employee $employee)
    {
        //
     
    }
    /**
     * Handle the employee "updated" event.
     */
    public function updated(Employee $employee)
    {
        //
    }

    public function updating(Employee $employee)
    {
        //
    
    }

    /**
     * Handle the employee "deleted" event.
     */
    public function deleted(Employee $employee)
    {
      
        $employee->employee_wages()->delete();
    }

    /**
     * Handle the employee "restored" event.
     */
    public function restored(Employee $employee)
    {
        //
    }

    /**
     * Handle the employee "force deleted" event.
     */
    public function forceDeleted(Employee $employee)
    {
        //TODO: preskumat poriadne
    }
}
