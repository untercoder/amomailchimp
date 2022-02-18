<?php

namespace App\Workers\Beanstalk;

use App\Workers\Task\TaskInterface;
use Pheanstalk\Pheanstalk;

class Beanstalk
{
    private Pheanstalk $connect;
    private BeanstalkConfig $config;

    public function __construct(BeanstalkConfig $config)
    {
        $this->config = $config;
    }

    public function send(TaskInterface $task): void
    {
        $connect = $this->getConnect();
        $connect->useTube($task->getTaskName());
        $connect->put(json_encode($task, JSON_THROW_ON_ERROR));
    }

    public function getConnect(): Pheanstalk
    {
        if (!isset($this->connect)) {
            $this->connect = Pheanstalk::create($this->config->getHost());
        }

        return $this->connect;
    }

}