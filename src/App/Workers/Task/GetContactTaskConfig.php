<?php

namespace App\Workers\Task;

use App\Workers\Beanstalk\Beanstalk;

class GetContactTaskConfig extends TaskConfig
{
    public function __construct(string $type, Beanstalk $queue, string $name)
    {
        parent::__construct($type, $queue, $name);
    }

}