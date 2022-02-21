<?php

namespace App\Workers\Task\Factories;

use App\Workers\Beanstalk\Beanstalk;
use App\Workers\Task\GetContactTaskConfig;
use Interop\Container\ContainerInterface;

class GetContactTaskConfigFactory
{
    public function __invoke(ContainerInterface $container): GetContactTaskConfig
    {
        $config = $container->get('cofig')['taskConfig'];
        $configName = $container->get('config')['contactWorker'];

        return new GetContactTaskConfig(
            $config['GET_TYPE'],
            $container->get(Beanstalk::class),
            $configName['queue']
        );
    }

}