<?php

declare(strict_types=1);

namespace App;

use AmoCRM\Client\AmoCRMApiClient;
use App\Factory\AmoApiCliFactory;
use App\Factory\AuthHandlerFactory;
use App\Factory\RedirectHandlerFactory;
use App\Handler\AuthHandler;
use App\Handler\RedirectHandler;
use App\Workers\Beanstalk\Beanstalk;
use App\Workers\Beanstalk\BeanstalkConfig;
use App\Workers\Beanstalk\BeanstalkConfigFactory;
use App\Workers\Beanstalk\BeanstalkFactory;
use App\Workers\Exec\AccountSyncWorker;
use App\Workers\Exec\AccountSyncWorkerFactory;
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
                AuthHandler::class => AuthHandlerFactory::class,
                AmoCRMApiClient::class => AmoApiCliFactory::class,
                Beanstalk::class=>BeanstalkFactory::class,
                BeanstalkConfig::class=>BeanstalkConfigFactory::class,
                AccountSyncWorker::class=>AccountSyncWorkerFactory::class,
                RedirectHandler::class => RedirectHandlerFactory::class

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

