<?php

namespace App\Observers;

use App\Workhour;

class WorkhourObserver
{
    /**
     * Handle the workhour "created" event.
     */
    public function created(Workhour $workhour)
    {
        //
    }

    /**
     * Handle the workhour "creating" event.
     */
    public function creating(Workhour $workhour)
    {
        // zistí poslednú platnú sadzbu
        // TODO porovnanie poslednej sadzby so zadaným dátumom
        // ! aby sa nestalo, že pri staršom dátume bude použitá posledná sadzba
            $sadzba = $workhour->employee->wages
                ->where('platnost', '<=', $workhour->datum)->last()->sadzba;
            // výpočet odpracovných hodín

            $from = strtotime($workhour->zaciatok);
            $to = strtotime($workhour->koniec);

            $odpracovane = ($to - $from) / 3600;

            // výpočet mzdy

            $mzda = $sadzba * $odpracovane;

            // doplní attribúty v databáze (predtým som mal na to triggers priamo v sql)
            $workhour->alias = $workhour->employee->alias;
            $workhour->sadzba = $sadzba;
            $workhour->odpracovane = $odpracovane;
            $workhour->mzda = $mzda;
    
    }

    /**
     * Handle the workhour
     */
    public function updated(Workhour $workhour)
    {
        //
    }

    public function updating(Workhour $workhour)
    {
        $sadzba = $workhour->employee->wages
            ->where('platnost', '<=', $workhour->datum)->last()->sadzba;

        // výpočet odpracovných hodín

        $from = strtotime($workhour->zaciatok);
        $to = strtotime($workhour->koniec);

        $odpracovane = ($to - $from) / 3600;

        // výpočet mzdy

        $mzda = $sadzba * $odpracovane;

        // doplní attribúty v databáze (predtým som mal na to triggers priamo v sql)
        $workhour->alias = $workhour->employee->alias;
        $workhour->sadzba = $sadzba;
        $workhour->odpracovane = $odpracovane;
        $workhour->mzda = $mzda;
    }


    /**
     * Handle the workhour "deleted" event.
     */
    public function deleted(Workhour $workhour)
    {
        //
    }

    /**
     * Handle the workhour "restored" event.
     */
    public function restored(Workhour $workhour)
    {
        //
    }

    /**
     * Handle the workhour "force deleted" event.
     */
    public function forceDeleted(Workhour $workhour)
    {
        //

    }


}
