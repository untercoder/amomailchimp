<?php
declare(strict_types=1);

namespace App\Factory;

use App\Handler\MainHandler;
use Psr\Container\ContainerInterface;
use App\Traits\MakeAmoClientTrait;

class MainHandlerFactory
{
    use MakeAmoClientTrait;
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container) : MainHandler
    {
        return new MainHandler($this->makeAmoClient($container));
    }

}