<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CandidatesImported extends Event
{
    use SerializesModels;

    public $total;
    public $imported;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($total, $imported_count)
    {
        $this->total = $total;
        $this->imported = $imported_count;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
