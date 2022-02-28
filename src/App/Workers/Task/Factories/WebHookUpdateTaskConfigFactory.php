<?php

namespace App\Workers\Task\Factories;

use App\Workers\Beanstalk\Beanstalk;
use App\Workers\Task\WebHookUpdateTaskConfig;
use Psr\Container\ContainerInterface;

class WebHookUpdateTaskConfigFactory
{
    public function __invoke(ContainerInterface $container): WebHookUpdateTaskConfig
    {
        $config = $container->get('config')['taskConfig'];
        $configName = $container->get('config')['contactWorker'];

        return new WebHookUpdateTaskConfig(
            $config['WEBHOOK_TYPE'],
            $container->get(Beanstalk::class),
            $configName['queue']
        );
    }


}