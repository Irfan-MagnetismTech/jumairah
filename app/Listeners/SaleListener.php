<?php

namespace App\Listeners;

use App\Events\SaleEvent;
use App\Mail\SalesCollectionMail;
use App\Mail\SellMail;
use App\Notifications\SaleNotification;
use App\Notifications\SalesCollectionNotificiation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SaleListener
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
     * @param  SaleEvent  $event
     * @return void
     */
    public function handle(SaleEvent $event)
    {
        $event->sell->sellClient->client->notify(new SaleNotification($event->sell));
//        auth()->user()->notify(new SaleNotification($event->sell));
//        Mail::to('sumonchandrashil@gmail.com', new SellMail($event->sell));
    }
}
