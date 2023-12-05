<?php

namespace App\Listeners;

use App\Events\SaleCollectionEvent;
use App\Notifications\SalesCollectionNotificiation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaleCollectionListener
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
     * @param  SaleCollectionEvent  $event
     * @return void
     */
    public function handle(SaleCollectionEvent $event)
    {
        $event->salesCollection->sell->sellClient->client->notify(new SalesCollectionNotificiation($event->salesCollection));
//        auth()->user()->notify(new SalesCollectionNotificiation($event->salesCollection));

    }
}
