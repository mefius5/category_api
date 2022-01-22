<?php

namespace App\Providers;

use App\Notifications\CategoryStoredNotification;
use App\Providers\CategoryStored;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailStoredCategoryNotification
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
     * @param  CategoryStored  $event
     * @return void
     */
    public function handle(CategoryStored $event)
    {
        $event->user->notify(new CategoryStoredNotification($event->category));
    }
}
