<?php

namespace App\Workers\Exec\GetContact;

use AmoCRM\Client\AmoCRMApiClient;
use App\Models\Contact;
use App\Workers\Exec\BeanstalkWorker;
use App\Traits\MakeAndRefreshTokenTrait;


class AccountSyncWorker extends BeanstalkWorker
{
    private const GET_TYPE = "create";
    private AmoCRMApiClient $client;
    use MakeAndRefreshTokenTrait;

    public function __construct(AccountSyncWorkerConfig $config)
    {
        $this->client = $config->getClient();
        parent::__construct($config->getQueue(), $config->getName(), $config->getQueueName());
    }

    /**
     * @param array $job
     *
     */
    protected function process(array $job): void
    {
        if($job['type'] === self::GET_TYPE) {
            $this->getContact($this->client, $job['data']['user_id']);
        }

    }

    private function getContact(AmoCRMApiClient $client, int $userId) {
        $token = $this->getToken($client, $userId);
        $domain = $client->getOAuthClient()->getAccountDomain($token)->getDomain();
        $contactsService = $client->setAccessToken($token)->setAccountBaseDomain($domain)->contacts();
        $contactsCollection = $contactsService->get();
        foreach ($contactsCollection as $contact) {
            $customFields = $contact->getCustomFieldsValues();

            $emails = $customFields->getBy('fieldCode', 'EMAIL');
            $emails = $emails->getValues();
            foreach ($emails as $email) {
                Contact::create([
                    'owner' => $userId,
                    'contact_id' => $contact->getId(),
                    'name' => $contact->getName(),
                    'email' => $email->getValue(),
                ]);
            }
        }
    }
}