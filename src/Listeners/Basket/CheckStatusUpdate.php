<?php

namespace OutMart\Listeners\Basket;

use Exception;
use OutMart\Enums\Baskets\Status;

class CheckStatusUpdate 
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // if (!$event->basket->canUpdateStatus()) {
        //     throw new Exception("Cannot update status");
        // }

        if (!in_array($event->basket->status, array_column(Status::cases(), 'value'))) {
            throw new Exception("The specified case is not recognized");
        }
    }
}
