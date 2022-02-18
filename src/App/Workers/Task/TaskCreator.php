<?php

namespace App\Workers\Task;

use App\Workers\Task\TaskInterface;

class TaskCreator implements TaskInterface
{
    /**
     * @var array
     */
    private array $data;
    private string $type;

    public function __construct(array $data, string $type)
    {
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'data' => $this->getData(),
            'type' => $this->getType(),
        ];
    }

    /**
     * @return string
     */
    public function getTaskName(): string
    {
//        return AccountSyncWorker::QUEUE;
    }

    /**
     * @inheritDoc
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getType(): string
    {
        return $this->type;
    }
}