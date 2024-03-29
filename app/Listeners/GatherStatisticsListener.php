<?php

namespace App\Listeners;

use App\Events\ExportFileUpdatedEvent;
use App\Services\MetaServiceInterface;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GatherStatisticsListener
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
     * @param  ExportFileUpdatedEvent  $event
     * @return void
     */
    public function handle(ExportFileUpdatedEvent $event)
    {
        resolve(MetaServiceInterface::class)
            ->gather();
    }
}
