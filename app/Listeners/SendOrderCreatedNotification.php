<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderCreatedNotification;
use App\Events\OrderCreated;
use App\Models\User;
use App\Models\Order;
use App\Models\Store;
use Illuminate\Support\Facades\Log;


class SendOrderCreatedNotification
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

    public function handle(OrderCreated $event)
    {
        $order = $event->order;
        $user = User::where('store_id',$order->store_id)->first(); 
        $user->notify(new OrderCreatedNotification($order));
    }
}


