<?php
declare(strict_types=1);

namespace App\Factory;

use App\Handler\GetUserNameHandler;
use App\Traits\MakeAmoClientTrait;
use Psr\Container\ContainerInterface;

class GetUserNameHandlerFactory
{
    use MakeAmoClientTrait;
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container) : GetUserNameHandler
    {
        return new GetUserNameHandler($this->makeAmoClient($container));
    }

}