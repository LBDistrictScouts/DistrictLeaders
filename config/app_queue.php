<?php
return [
    'Queue' => [
        // time (in seconds) after which a job is re-queued if the worker doesn't report back
        'defaultworkertimeout' => '1800',
        // seconds of running time after which the worker will terminate (0 = unlimited)
        'workermaxruntime' => '600',
        // minimum time (in seconds) which a task remains in the database before being cleaned up.
        'cleanuptimeout' => '2592000', // 30 days
        // Seconds of running time after which the PHP process of the worker will terminate (0 = unlimited)
        'workertimeout' => '12000',
        /* Optional */
        'isSearchEnabled' => true,
    ],
];
