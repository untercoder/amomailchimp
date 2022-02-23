<?php

namespace App\Workers\Exec\GetContact;

use AmoCRM\Client\AmoCRMApiClient;
use App\Models\Contact;
use App\Workers\Exec\BeanstalkWorker;
use App\Traits\MakeAndRefreshTokenTrait;
use League\OAuth2\Client\Token\AccessTokenInterface;


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
        if($job['type'] === self::GET_TYPE)
        {
            $userId = $job['data']['user_id'];
            $checkContact = Contact::where('owner', '=', $userId)->exists();
            if(!$checkContact) {
                $token = $this->getToken($this->client, $userId);
                if(isset($token)) {
                    $this->getContact($userId, $token);
                } else {
                    echo "Error auth user not found!";
                }

            }
        }

    }

    private function getContact(int $userId, AccessTokenInterface $token)
    {
        $domain = $this->client->getOAuthClient()->getAccountDomain($token)->getDomain();
        $contactsService = $this->client->setAccessToken($token)->setAccountBaseDomain($domain)->contacts();

        try
        {
            $contactsCollection = $contactsService->get();
            while (true)
            {
                foreach ($contactsCollection as $contact)
                {
                    $customFields = $contact->getCustomFieldsValues();
                    if(isset($customFields))
                    {
                        $emails = $customFields->getBy('fieldCode', 'EMAIL');
                        if(isset($emails))
                        {
                            $emails = $emails->getValues();
                        }
                        else{continue;}
                    }
                    else {continue;}

                    if(isset($emails))
                    {
                        foreach ($emails as $email)
                        {
                            Contact::create([
                                'owner' => $userId,
                                'contact_id' => $contact->getId(),
                                'name' => $contact->getName(),
                                'email' => $email->getValue(),
                            ]);
                        }
                    }
                }
                $contactsCollection = $contactsService->nextPage($contactsCollection);
            }

        }
        catch (\AmoCRM\Exceptions\AmoCRMApiNoContentException $e)
        {
            return;
        }
        catch (\AmoCRM\Exceptions\AmoCRMApiPageNotAvailableException $e)
        {
            return;
        }

    }
}