<?php

namespace App\Factories;

use MailchimpMarketing\ApiClient;
use Psr\Container\ContainerInterface;

class MailchimpCliFactory
{
    public function __invoke(ContainerInterface $container): ApiClient
    {
        $mailchimp = new ApiClient();
        $config = $container->get('config')['mailchimp'];
        $mailchimp->setConfig([
            'apiKey' => $config['apiKey'],
            'server' => $config['server'],
        ]);

        return $mailchimp;
    }
}