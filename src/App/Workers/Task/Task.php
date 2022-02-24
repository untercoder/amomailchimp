<?php

namespace App\Workers\Task;

use App\Workers\Beanstalk\Beanstalk;

abstract class Task
{
    private string $type;
    private Beanstalk $queue;
    private string $name;
    private array $data;

    /**
     * @param array $data
     * @param string $type
     * @param string $name
     */
    public function __construct(string $type, Beanstalk $queue, string $name)
    {
        $this->name = $name;
        $this->type = $type;
        $this->queue = $queue;
    }

    /**
     * @return string
     */
    public function getTaskType(): string
    {
        return $this->type;
    }

    /**
     * @return Beanstalk
     */
    public function getTaskQueue(): Beanstalk
    {
        return $this->queue;
    }

    /**
     * @return string
     */
    public function getTaskName(): string
    {
        return $this->name;
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