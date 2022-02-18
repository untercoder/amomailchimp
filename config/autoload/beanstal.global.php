<?php
declare(strict_types=1);

return ['beanstalk' =>[
'host' => getenv('BEANSTALK_HOST'),
'port' => getenv('BEANSTALK_PORT'),
'timeout' => getenv('BEANSTALK_TIMEOUT'),
]
];
