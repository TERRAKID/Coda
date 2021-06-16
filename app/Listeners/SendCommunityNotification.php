<?php

namespace App\Listeners;

use App\Events\NewCommunityMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCommunityNotification
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
     * @param  NewCommunityMessage  $event
     * @return void
     */
    public function handle(NewCommunityMessage $event)
    {
        //
    }
}
