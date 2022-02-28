<?php

declare(strict_types=1);

namespace App\Workers\Beanstalk\Factories;

use App\Workers\Beanstalk\Beanstalk;
use App\Workers\Beanstalk\BeanstalkConfig;
use Psr\Container\ContainerInterface;

class BeanstalkFactory
{
    public function __invoke(ContainerInterface $container): Beanstalk
    {        
        return new Beanstalk($container->get(BeanstalkConfig::class));
    }
}
