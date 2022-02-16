<?php

declare(strict_types=1);

namespace App;

use AmoCRM\Client\AmoCRMApiClient;
use App\Factory\AmoApiCliFactory;
use App\Factory\GetUserNameHandlerFactory;
use App\Factory\MainHandlerFactory;
use App\Handler\GetUserNameHandler;
use App\Handler\MainHandler;
use App\Helper\AmoCRMClientFactory;
use Whoops\Handler\Handler;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'invokables' => [
            ],
            'factories' => [
                GetUserNameHandler::class => GetUserNameHandlerFactory::class,
                MainHandler::class => MainHandlerFactory::class,
                AmoCRMApiClient::class => AmoApiCliFactory::class,
            ],
        ];
    }
    /**
     * Returns the templates configuration
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app'    => ['templates/app'],
                'error'  => ['templates/error'],
                'layout' => ['templates/layout'],
            ],
        ];
    }

}
