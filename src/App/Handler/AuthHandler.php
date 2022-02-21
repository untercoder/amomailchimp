<?php
declare(strict_types=1);
namespace App\Handler;

use AmoCRM\Client\AmoCRMApiClient;
use App\Session\AuthUser;
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

        if(isset($queryParams['code'], $queryParams['referer']))
        {
            $this->amoApiClient->setAccountBaseDomain($queryParams['referer']);
            $accessToken = $this->amoApiClient->getOAuthClient()->getAccessTokenByCode($queryParams['code']);
            $ownerDetails = $this->amoApiClient->getOAuthClient()->getResourceOwner($accessToken);
            $authUserId = $ownerDetails->getId();
            $userName = $ownerDetails->getName();

            if(!AuthUser::userIsAuth()) {
                AuthUser::setAuthUser($authUserId);
                User::create
                (
                    [
                        'amo_auth_user_id' => $authUserId,
                        'access_token' => $accessToken->getToken(),
                        'refresh_token' => $accessToken->getRefreshToken(),
                        'base_domain' => $this->amoApiClient->getAccountBaseDomain(),
                        'expires' => $accessToken->getExpires(),
                    ]
                );

            }
            $response = new HtmlResponse(sprintf(
                '<h1>Привет %s ты успешно авторизовался!</h1>',
                $userName
            ));;
        }
        else
        {
            $response = new HtmlResponse(sprintf(
                '<h1>Упс! Отсутствует код авторизации</h1>'
            ));
        }

        return $response;

    }
}

