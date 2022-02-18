<?php

namespace App\Workers\Exec;

use App\Workers\Beanstalk\Beanstalk;

class AccountSyncWorker extends BeanstalkWorker
{
    public const NAME = 'crm:worker:account_sync';
    public const QUEUE = 'account_sync';

    public function __construct(Beanstalk $queue)
    {
        parent::__construct($queue);
    }

    protected function myName(): string
    {
        return self::NAME;
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