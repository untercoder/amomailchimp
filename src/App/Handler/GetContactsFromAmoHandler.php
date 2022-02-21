<?php

namespace App\Handler;

use App\Session\AuthUser;
use App\Workers\Task\GetContactTask;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GetContactsFromAmoHandler implements RequestHandlerInterface
{
    private GetContactTask $task;

    /**
     * @param GetContactTask $task
     */
    public function __construct(GetContactTask $task)
    {
        $this->task = $task;
    }


    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->task->setTaskData([
            'user_id' => AuthUser::getAuthUser()
        ]);
        $this->task->makeTask();

        return new JsonResponse([
            'response' => 'sync started',
           ]);
    }
}