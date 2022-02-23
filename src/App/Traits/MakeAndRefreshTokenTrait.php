<?php

namespace App\Traits;

use AmoCRM\Client\AmoCRMApiClient;
use App\Models\User;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;
use Throwable;

trait MakeAndRefreshTokenTrait
{
    public function getToken(AmoCRMApiClient $client, int $userId): AccessTokenInterface
    {
        try {
            $tokenData = User::where('amo_auth_user_id', '=', $userId)->first();
            if(isset($tokenData))
            {
                $arrayToToken = [
                    'access_token' => $tokenData['access_token'],
                    'refresh_token' => $tokenData['refresh_token'],
                    'expires' => $tokenData['expires'],
                ];
                $token = new AccessToken($arrayToToken);
            }
            else {
                $token = null;
            }

        } catch (Throwable $exception) {
            echo "Error user not found!".$exception;
        }


        if (time() >= $tokenData['expires']) {
            $accessToken = $client->getOAuthClient()->getAccessTokenByRefreshToken($token);
            $tokenData->setAttribute('access_token', $accessToken->getToken());
            $tokenData->setAttribute('refresh_token', $accessToken->getRefreshToken());
            $tokenData->setAttribute('expires', $accessToken->getExpires());
            $tokenData->save();
            $token = $accessToken;
        }

        return $token;
    }
}