<?php

namespace App\Workers\Exec\GetContact;

use AmoCRM\Client\AmoCRMApiClient;
use App\Workers\Beanstalk\Beanstalk;
use MailchimpMarketing\ApiClient;

class AccountSyncWorkerConfig
{
    private string $name;
    private string $queueName;
    private Beanstalk $queue;
    private AmoCRMApiClient $clientAmo;
    private ApiClient $clientMailchimp;


    public function __construct(string $name,
                                string $queueName,
                                Beanstalk $queue,
                                AmoCRMApiClient $clientAmo,
                                ApiClient $clientMailchimp
    )
    {
        $this->clientMailchimp = $clientMailchimp;
        $this->clientAmo = $clientAmo;
        $this->queue = $queue;
        $this->name = $name;
        $this->queueName = $queueName;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getQueueName(): string
    {
        return $this->queueName;
    }

    /**
     * @return Beanstalk
     */
    public function getQueue(): Beanstalk
    {
        return $this->queue;
    }

    /**
     * @return AmoCRMApiClient
     */
    public function getClientAmo(): AmoCRMApiClient
    {
        return $this->clientAmo;
    }

    /**
     * @return ApiClient
     */
    public function getClientMailchimp(): ApiClient
    {
        return $this->clientMailchimp;
    }


}