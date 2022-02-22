<?php

namespace App\Handler;

use App\Session\AuthUser;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class OutHandler implements RequestHandlerInterface
{

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $user = AuthUser::getAuthUser();
        AuthUser::unsetAuthUser();
        return new JsonResponse([
            $user => "is out"
        ]);
    }
}