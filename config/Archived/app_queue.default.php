<?php
return [
    'Queue' => [
        // time (in seconds) after which a job is re-queued if the worker doesn't report back
        'defaultworkertimeout' => '<<QUEUE_WORKER_DEFAULT_TIMEOUT>>',
        // seconds of running time after which the worker will terminate (0 = unlimited)
        'workermaxruntime' => '<<QUEUE_WORKER_RUNTIME>>',
        // minimum time (in seconds) which a task remains in the database before being cleaned up.
        'cleanuptimeout' => '<<QUEUE_WORKER_CLEANUP_TIMEOUT>>', // 30 days
        // Seconds of running time after which the PHP process of the worker will terminate (0 = unlimited)
        'workertimeout' => '<<QUEUE_WORKER_RUNTIME_TERMINATION>>',
        /* Optional */
        'isSearchEnabled' => true,
    ],
];
