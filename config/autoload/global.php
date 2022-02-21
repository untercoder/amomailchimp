<?php
declare(strict_types=1);

return [
    'laminas-cli' => [
        'commands' => [
            'crm:worker:account_sync' => \App\Workers\Exec\GetContact\AccountSyncWorker::class,
        ],
    ],
];
