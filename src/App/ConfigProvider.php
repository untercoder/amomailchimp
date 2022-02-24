<?php

declare(strict_types=1);

namespace App;

use AmoCRM\Client\AmoCRMApiClient;
use App\Factories\AmoApiCliFactory;
use App\Factories\AuthHandlerFactory;
use App\Factories\GetContactsFromAmoHandlerFactory;
use App\Factories\RedirectHandlerFactory;
use App\Factories\WebHookHandlerFactory;
use App\Handler\AuthHandler;
use App\Handler\GetContactsFromAmoHandler;
use App\Handler\RedirectHandler;
use App\Handler\WebHookHandler;
use App\Workers\Beanstalk\Beanstalk;
use App\Workers\Beanstalk\BeanstalkConfig;
use App\Workers\Beanstalk\Factories\BeanstalkConfigFactory;
use App\Workers\Beanstalk\Factories\BeanstalkFactory;
use App\Workers\Exec\GetContact\AccountSyncWorker;
use App\Workers\Exec\GetContact\AccountSyncWorkerConfig;
use App\Workers\Exec\GetContact\Factories\AccountSyncWorckerConfigFactory;
use App\Workers\Exec\GetContact\Factories\AccountSyncWorkerFactory;
use App\Workers\Task\Factories\GetContactTaskConfigFactory;
use App\Workers\Task\Factories\GetContactTaskFactory;
use App\Workers\Task\Factories\WebHookUpdateTaskConfigFactory;
use App\Workers\Task\Factories\WebHookUpdateTaskFactory;
use App\Workers\Task\GetContactTask;
use App\Workers\Task\GetContactTaskConfig;
use App\Workers\Task\WebHookUpdateTask;
use App\Workers\Task\WebHookUpdateTaskConfig;

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
                RedirectHandler::class => RedirectHandlerFactory::class,
                AccountSyncWorkerConfig::class => AccountSyncWorckerConfigFactory::class,
                GetContactTaskConfig::class => GetContactTaskConfigFactory::class,
                GetContactTask::class => GetContactTaskFactory::class,
                WebHookUpdateTaskConfig::class => WebHookUpdateTaskConfigFactory::class,
                WebHookUpdateTask::class => WebHookUpdateTaskFactory::class,
                WebHookHandler::class => WebHookHandlerFactory::class,
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

