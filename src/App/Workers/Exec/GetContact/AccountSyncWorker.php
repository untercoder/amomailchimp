<?php

namespace App\Workers\Exec\GetContact;

use AmoCRM\Client\AmoCRMApiClient;
use App\Models\Contact;
use App\Workers\Exec\BeanstalkWorker;
use App\Traits\MakeAndRefreshTokenTrait;
use League\OAuth2\Client\Token\AccessTokenInterface;
use App\Traits\SaveContactsTraits;
use App\Traits\UpdateContactStausTrait;


class AccountSyncWorker extends BeanstalkWorker
{
    private const GET_TYPE = "create";
    private const WEBHOOK_TYPE = 'update';
    private AmoCRMApiClient $client;
    use MakeAndRefreshTokenTrait;
    use SaveContactsTraits;
    use UpdateContactStausTrait;

    public function __construct(AccountSyncWorkerConfig $config)
    {
        $this->client = $config->getClient();
        parent::__construct($config->getQueue(), $config->getName(), $config->getQueueName());
    }

    protected function process(array $job): void
    {
        if ($job['type'] === self::GET_TYPE) {
            $this->createContactsController($job['data']['user_id']);
        }

        if ($job['type'] === self::WEBHOOK_TYPE) {
            $this->updateContactController($job['data']);
        }

    }

    private function createContactsController($userId): void
    {
        $checkContact = Contact::where('owner', '=', $userId)->exists();
        if (!$checkContact) {
            $token = $this->getToken($this->client, $userId);
            if (isset($token)) {
                $this->saveContact($userId, $token, $this->client);
            } else {
                echo "Error auth user not found!";
            }
        }
    }

    private function updateContactController($actions) {
        switch ($actions) {
            case isset($actions['data']['add']):
                $owner = $actions['data']['add'][0]['responsible_user_id'];
                $data = $actions['data']['add'];
                $this->addContact($owner, $data);
                break;
            case isset($actions['data']['delete']):
                $idContact = $actions['data']['delete'];
                $this->deleteContact($idContact);
                break;
            case isset($actions['data']['update']):
                $owner = $actions['data']['update'][0]['responsible_user_id'];
                $data = $actions['data']['update'];
                $this->updateContact($owner, $data);
                break;
        }
    }


}