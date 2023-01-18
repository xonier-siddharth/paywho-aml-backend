<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use App\Events\MonitorTransactionEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MonitorTransactionEventListener implements ShouldQueue
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
     * @param  \App\Events\MonitorTransactionEvent  $event
     * @return void
     */
    public function handle(MonitorTransactionEvent $event)
    {
        // dd($event);
        echo 'here';
    }
}
