<?php

namespace App\Workers\Exec\GetContact;

use App\Workers\Beanstalk\Beanstalk;
use App\Workers\Exec\BeanstalkWorker;

class AccountSyncWorker extends BeanstalkWorker
{
    public function __construct(AccountSyncWorkerConfig $config)
    {
        parent::__construct($config->getQueue(), $config->getName(), $config->getQueueName());
    }


    /**
     * @param array $job
     *
     */
    protected function process(array $job): void
    {
        echo $this->myName()." work";
    }
}