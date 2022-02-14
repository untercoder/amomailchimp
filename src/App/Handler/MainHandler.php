<?php

declare(strict_types=1);

namespace App\Handler;

use AmoCRM\Client\AmoCRMApiClient;
use Illuminate\Database\Capsule\Manager;
use Laminas\Diactoros\Response\JsonResponse;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Models\User;
use App\Traits\TouchEloquentTrait;

class MainHandler implements RequestHandlerInterface
{
    private AmoCRMApiClient $amoApiClient;
    private AccessToken $accessToken;
    private string $name;
    private User $user;
    private Manager $dataBase;
    use TouchEloquentTrait;


    public function __construct(AmoCRMApiClient $amoApiCli)
    {
        $this->amoApiClient = $amoApiCli;
        $this->dataBase = $this->startEloquent();
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $queryParams = $request->getQueryParams();

        if(isset($queryParams['code']) and isset($queryParams['referer'])) {
            $this->amoApiClient->setAccountBaseDomain($queryParams['referer']);
            $this->accessToken = $this->amoApiClient->getOAuthClient()->getAccessTokenByCode($queryParams['code']);
            $this->user = User::create(
                [
                    'access_token' => $this->accessToken->getToken(),
                    'refresh_token' => $this->accessToken->getRefreshToken(),
                    'base_domain' => $this->amoApiClient->getAccountBaseDomain(),
                    'expires' => $this->accessToken->getExpires(),
                ]
            );
            die("Save token success");
        }

        $this->user = User::latest()->first();

        if(isset($this->user)) {
            $this->accessToken = new AccessToken([
            'access_token' => $this->user->access_token,
            'refresh_token' => $this->user->refresh_token,
            'expires' => $this->user->expires,
            ]);
            $this->amoApiClient->setAccountBaseDomain($this->user->base_domain);
            $ownerDetails = $this->amoApiClient->getOAuthClient()->getResourceOwner($this->accessToken);
            $this->name = $ownerDetails->getName();
        }

        if (isset($this->name)) {
            $response = ["Name" => $this->name];
        } else {
            $response = ["Error" => "Error!"];
        }

        return new JsonResponse($response);
    }
}
