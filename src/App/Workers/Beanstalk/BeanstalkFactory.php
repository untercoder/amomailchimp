<?php

declare(strict_types=1);

namespace App\Workers\Beanstalk;

use Psr\Container\ContainerInterface;

class BeanstalkFactory
{
    public function __invoke(ContainerInterface $container): Beanstalk
    {        
        return new Beanstalk($container->get(BeanstalkConfig::class));
    }
}
