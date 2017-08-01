<?php

namespace App\Listeners;

use App\Events\CandidatesImported;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\ImportStatus as Status;

class ImportStatus
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  CandidatesImported  $event
     * @return void
     */
    public function handle(CandidatesImported $event)
    {
        $status = Status::firstOrNew(['id' => 1]);
        $status->total = $event->total;
        $status->completed = isset($status->completed) ? $status->completed + $event->imported : $event->imported;
        $status->save();
    }
}
