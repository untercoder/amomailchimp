<?php

declare(strict_types=1);

namespace App\Handler;

use AmoCRM\Client\AmoCRMApiClient;
use Laminas\Diactoros\Response\JsonResponse;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MainHandler implements RequestHandlerInterface
{
    private AmoCRMApiClient $amoApiClient;
    private AccessToken $accessToken;
    private string $name;


    public function __construct(AmoCRMApiClient $amoApiCli)
    {
        $this->amoApiClient = $amoApiCli;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $queryParams = $request->getQueryParams();

        if(!isset($queryParams['code'])) {
            $this->accessToken = $this->amoApiClient->getOAuthClient()->getAccessTokenByCode($queryParams['code']);
            $this->amoApiClient->setAccountBaseDomain($queryParams['referer']);
        }
        if(isset($this->accessToken)) {
            $ownerDetails = $this->amoApiClient->getOAuthClient()->getResourceOwner($this->accessToken);
            $this->name = $ownerDetails->getName();
        }

        if (isset($this->name)) {
            $response = ["Name" => $this->name];
        } else {
            $response = ["Error" => "Error!"];
        }

        return new JsonResponse([
            "Name" => $response
        ]);
    }
}
