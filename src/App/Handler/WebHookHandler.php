<?php

namespace App\Handler;

use App\Workers\Task\WebHookUpdateTask;
use Laminas\Diactoros\Response\EmptyResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class WebHookHandler implements RequestHandlerInterface
{

    private WebHookUpdateTask $task;

    public function __construct(WebHookUpdateTask $task)
    {
        $this->task = $task;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->task->setTaskData([
            'data' => $request->getParsedBody()['contacts']
        ]);
        $this->task->makeTask();
        return new EmptyResponse();
    }
}