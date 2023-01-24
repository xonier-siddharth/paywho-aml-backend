<?php

namespace App\Listeners;

use App\Http\Controllers\Api\MonitorController;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Log;
use App\Events\MonitorTransactionEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MonitorTransactionEventListener implements ShouldQueue
{
    public $transactionService;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\MonitorTransactionEvent  $event
     * @return void
     */
    public function handle(MonitorTransactionEvent $event)
    {
        $transaction_data = $event->transaction_data;
        $rules = $event->rules;

        $result = $this->transactionService->validate_transaction($transaction_data, $rules);
        dd($result);
    }
}
