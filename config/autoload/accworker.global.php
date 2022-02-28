<?php
return [
    'contactWorker' => [
        'name' => 'crm:worker:account_sync',
        'queue' => 'account_sync',
    ],
    'taskConfig' => [
        'GET_TYPE' => 'create',
        'WEBHOOK_TYPE' => 'update',
    ]
];