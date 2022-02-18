<?php

namespace App\Workers\Exec;
use App\Workers\Beanstalk\Beanstalk;
use Psr\Container\ContainerInterface;

class AccountSyncWorkerFactory
{
    public function __invoke(ContainerInterface $container): AccountSyncWorker
    {
        return new AccountSyncWorker(
            $container->get(Beanstalk::class)
        );
    }
}