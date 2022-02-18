<?php
declare(strict_types=1);

return [
    'laminas-cli' => [
        'commands' => [
            'crm:worker:account_sync' => \App\Workers\Exec\AccountSyncWorker::class,
        ],
    ],
];
