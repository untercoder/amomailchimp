<?php
declare(strict_types=1);

namespace App\Handler;

use AmoCRM\Client\AmoCRMApiClient;
use Laminas\Diactoros\Response\JsonResponse;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Models\User;

class MainHandler implements RequestHandlerInterface
{
    private AmoCRMApiClient $amoApiClient;
    private AccessToken $accessToken;
    private array $response;


    public function __construct(AmoCRMApiClient $amoApiCli)
    {
        $this->amoApiClient = $amoApiCli;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $queryParams = $request->getQueryParams();

        if(isset($queryParams['code']) && isset($queryParams['referer'])) {
            $this->amoApiClient->setAccountBaseDomain($queryParams['referer']);
            $this->accessToken = $this->amoApiClient->getOAuthClient()->getAccessTokenByCode($queryParams['code']);
            $ownerDetails = $this->amoApiClient->getOAuthClient()->getResourceOwner($this->accessToken);
            $authUserId = $ownerDetails->getId();
            User::create(
                [
                    'amo_auth_user_id' => $authUserId,
                    'access_token' => $this->accessToken->getToken(),
                    'refresh_token' => $this->accessToken->getRefreshToken(),
                    'base_domain' => $this->amoApiClient->getAccountBaseDomain(),
                    'expires' => $this->accessToken->getExpires(),
                ]
            );
            $this->response = ["Ok" => "User create success!"];
        } else {
            $this->response = ["Error" => "No auth code or referer"];
        }

        return new JsonResponse($this->response);

    }
}
