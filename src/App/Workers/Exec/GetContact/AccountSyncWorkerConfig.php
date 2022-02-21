<?php

namespace App\Workers\Exec\GetContact;

use App\Workers\Beanstalk\Beanstalk;

class AccountSyncWorkerConfig
{
    private string $name;
    private string $queueName;
    private Beanstalk $queue;

    public function __construct(string $name, string $queueName, Beanstalk $queue )
    {
        $this->queue = $queue;
        $this->name = $name;
        $this->queueName = $queueName;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getQueueName(): string
    {
        return $this->queueName;
    }

    /**
     * @return Beanstalk
     */
    public function getQueue(): Beanstalk
    {
        return $this->queue;
    }





}