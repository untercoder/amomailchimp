<?php

namespace App\Workers\Exec\GetContact\Factories;
use App\Workers\Exec\GetContact\AccountSyncWorker;
use App\Workers\Exec\GetContact\AccountSyncWorkerConfig;
use Psr\Container\ContainerInterface;

class AccountSyncWorkerFactory
{
    public function __invoke(ContainerInterface $container): AccountSyncWorker
    {
        return new AccountSyncWorker(
            $container->get(AccountSyncWorkerConfig::class)
        );
    }
}