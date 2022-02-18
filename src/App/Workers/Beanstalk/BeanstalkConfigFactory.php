<?php

declare(strict_types=1);

namespace App\Workers\Beanstalk;

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
