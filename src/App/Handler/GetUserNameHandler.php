<?php
declare(strict_types=1);
namespace App\Handler;

use AmoCRM\Client\AmoCRMApiClient;
use App\Models\User;
use Laminas\Diactoros\Response\HtmlResponse;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class GetUserNameHandler implements RequestHandlerInterface
{
    private AmoCRMApiClient $amoApiClient;
    private AccessToken $accessToken;
    private string $name;
    private User $user;

    public function __construct(AmoCRMApiClient $amoApiCli, User $user)
    {
        $this->amoApiClient = $amoApiCli;
        $this->user = $user;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();

        if(isset($this->user)) {
            $this->accessToken = new AccessToken([
                'access_token' => $this->user->getAttributeFromArray('access_token'),
                'refresh_token' => $this->user->getAttributeFromArray('refresh_token'),
                'expires' => $this->user->getAttributeFromArray('expires'),
            ]);
            $this->amoApiClient->setAccountBaseDomain($this->user->base_domain);
            $ownerDetails = $this->amoApiClient->getOAuthClient()->getResourceOwner($this->accessToken);
            $this->name = $ownerDetails->getName();
        }

        if (isset($this->name)) {
            $response = $this->name;
        } else {
            $response = "Error!";
        }

        return new HtmlResponse(sprintf(
            '<h1>Username: %s</h1>',
            $response
        ));

    }
}