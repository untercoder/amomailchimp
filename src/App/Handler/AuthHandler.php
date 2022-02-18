<?php
declare(strict_types=1);
namespace App\Handler;
session_start();

use AmoCRM\Client\AmoCRMApiClient;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Models\User;

class AuthHandler implements RequestHandlerInterface
{
    private AmoCRMApiClient $amoApiClient;

    public function __construct(AmoCRMApiClient $amoApiCli)
    {
        $this->amoApiClient = $amoApiCli;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $queryParams = $request->getQueryParams();

        if(isset($queryParams['code']) && isset($queryParams['referer']))
        {
            $this->amoApiClient->setAccountBaseDomain($queryParams['referer']);
            $accessToken = $this->amoApiClient->getOAuthClient()->getAccessTokenByCode($queryParams['code']);
            $ownerDetails = $this->amoApiClient->getOAuthClient()->getResourceOwner($accessToken);
            $authUserId = $ownerDetails->getId();
            $userName = $ownerDetails->getName();
            User::create
            (
                [
                    'amo_auth_user_id' => $authUserId,
                    'access_token' => $this->accessToken->getToken(),
                    'refresh_token' => $this->accessToken->getRefreshToken(),
                    'base_domain' => $this->amoApiClient->getAccountBaseDomain(),
                    'expires' => $this->accessToken->getExpires(),
                ]
            );
            $response = new HtmlResponse(sprintf(
                '<h1>Привет %s ты успешно авторизовался!</h1>',
                $userName
            ));;
        }
        else
        {
            $state = bin2hex(random_bytes(16));
            $_SESSION['oauth2state'] = $state;
            $authorizationUrl = $this->amoApiClient->getOAuthClient()->getAuthorizeUrl([
                'state' => $state,
                'mode' => 'post_message',
            ]);

            $this->response = new RedirectResponse($authorizationUrl);

        }

        return $response;

    }
}

