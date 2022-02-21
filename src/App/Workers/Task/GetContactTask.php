<?php

namespace App\Workers\Task;

use App\Workers\Beanstalk\Beanstalk;
use App\Workers\Exec\GetContact\Factories\AccountSyncWorckerConfigFactory;

class GetContactTask extends Task
{
    public function __construct(GetContactTaskConfig $config)
    {
        parent::__construct($config->getType(), $config->getQueue(), $config->getName());
    }


    public function getTaskBody() {
        return [
            'type' => $this->getTaskType(),
            'data' => $this->getTaskName(),
        ];
    }


    public function makeTask(): void
    {
        $beanstalk = $this->getTaskQueue();
        $beanstalk->send($this->getTaskName(), $this->getTaskBody());
    }
}