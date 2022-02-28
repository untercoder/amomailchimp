<?php

namespace App\Workers\Beanstalk;


class BeanstalkConfig
{
    /** @var string */
    protected string $host;

    /**
     * @param string $host
     */
    public function __construct(string $host)
    {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

}
