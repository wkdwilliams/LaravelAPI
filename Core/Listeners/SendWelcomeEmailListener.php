<?php

namespace Core\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;

class SendWelcomeEmailListener implements ShouldQueue
{

    public function handle($event)
    {
        echo $event->entity->getEmail(); // Returns email of newly created user
    }
}
