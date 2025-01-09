<?php

namespace App\Observers;

use App\Job;

class JobObserver
{
    /**
     * Handle the job "created" event.
     */
    public function created(Job $job)
    {
        //
    }

    public function creating(Job $job)
    {

        // výpočet odpracovných hodín

        $from = strtotime($job->zaciatok);
        $to = strtotime($job->koniec);

        $odpracovane = ($to - $from) / 3600;

        // výpočet mzdy

        // doplní attribúty v databáze (predtým som mal na to triggers priamo v sql)
        $job->alias = $job->employee->alias;
        $job->odpracovane = $odpracovane;
    }

    /**
     * Handle the job "updated" event.
     */
    public function updating(Job $job)
    {

        // výpočet odpracovných hodín

        $from = strtotime($job->zaciatok);
        $to = strtotime($job->koniec);

        $odpracovane = ($to - $from) / 3600;

        // výpočet mzdy

        // doplní attribúty v databáze (predtým som mal na to triggers priamo v sql)
        $job->user_id = \Auth::user()->id;
        $job->alias = $job->employee->alias;
        $job->odpracovane = $odpracovane;
        //
    }

    /**
     * Handle the job "deleted" event.
     */
    public function deleted(Job $job)
    {
        //
    }

    /**
     * Handle the job "restored" event.
     */
    public function restored(Job $job)
    {
        //
    }

    /**
     * Handle the job "force deleted" event.
     */
    public function forceDeleted(Job $job)
    {
        //
    }
}
