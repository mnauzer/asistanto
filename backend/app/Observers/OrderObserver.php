<?php

namespace App\Observers;

use App\Order;


class OrderObserver
{
    /**
     * Handle the order "creating" event.
     */
    public function created(Order $order)
    {
    }
    public function creating(Order $order)
    {
       // $order->alias = $order->customer->alias;
    }

    /**
     * Handle the order
     */
    public function updated(Order $order)
    {
    }

    public function updating(Order $order)
    {
       // $order->alias = $order->customer->alias;
    }
}
