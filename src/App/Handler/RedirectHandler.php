<?php

namespace App\Handler;
session_start();

use AmoCRM\Client\AmoCRMApiClient;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RedirectHandler implements RequestHandlerInterface

{
    private AmoCRMApiClient $amoApiClient;

    public function __construct(AmoCRMApiClient $amoApiCli)
    {
        $this->amoApiClient = $amoApiCli;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $state = bin2hex(random_bytes(16));
        $_SESSION['oauth2state'] = $state;
        $authorizationUrl = $this->amoApiClient->getOAuthClient()->getAuthorizeUrl([
            'state' => $state,
            'mode' => 'post_message',
        ]);

         return new RedirectResponse($authorizationUrl);
    }

}