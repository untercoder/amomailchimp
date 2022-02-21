<?php

declare(strict_types=1);

namespace App\Workers\Beanstalk\Factories;

use App\Workers\Beanstalk\BeanstalkConfig;
use Psr\Container\ContainerInterface;

class BeanstalkConfigFactory
{
    public function __invoke(ContainerInterface $container): BeanstalkConfig
    {
        $config = $container->get('config')['beanstalk'];
        
        return new BeanstalkConfig(
           $config['host'],
        );
    }
}
