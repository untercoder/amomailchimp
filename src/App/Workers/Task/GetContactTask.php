<?php

namespace App\Workers\Task;

use App\Workers\Beanstalk\Beanstalk;
use App\Workers\Exec\GetContact\Factories\AccountSyncWorckerConfigFactory;

class GetContactTask extends Task
{
    private array $data;

    public function __construct(GetContactTaskConfig $config)
    {
        parent::__construct($config->getType(), $config->getQueue(), $config->getName());
    }

    /**
     * @return array
     */
    public function getTaskData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setTaskData(array $data): void
    {
        $this->data = $data;
    }



    public function getTaskBody() {
        return [
            'type' => $this->getTaskType(),
            'data' => $this->getTaskData(),
        ];
    }




    public function makeTask(): void
    {
        $beanstalk = $this->getTaskQueue();
        $beanstalk->send($this->getTaskName(), $this->getTaskBody());
    }
}