<?php

namespace App\Workers\Task;

use App\Workers\Beanstalk\Beanstalk;

class WebHookUpdateTask extends Task
{
    public function __construct(WebHookUpdateTaskConfig $config)
    {
        parent::__construct($config->getType(), $config->getQueue(), $config->getName());
    }

}