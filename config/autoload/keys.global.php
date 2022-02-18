<?php

declare(strict_types=1);

return [
    'keys' => [
        "secretKey" => getenv('AMO_SECRET_KEY'),
        "integrationId" => getenv('AMO_INTEGRATION_ID'),
        "redirectURI" => getenv('AMO_REDIRECT_URI'),
    ],

];

