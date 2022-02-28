<?php

namespace App\Workers\Task;

use App\Workers\Beanstalk\Beanstalk;

abstract class TaskConfig
{
    private string $type;
    private Beanstalk $queue;
    private string $name;

    /**
     * @param string $name
     * @param string $type
     */
    public function __construct(string $type, Beanstalk $queue, string $name)
    {
        $this->queue = $queue;
        $this->type = $type;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return Beanstalk
     */
    public function getQueue(): Beanstalk
    {
        return $this->queue;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

}