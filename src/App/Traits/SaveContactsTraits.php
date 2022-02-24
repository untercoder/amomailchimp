<?php

namespace App\Traits;

use AmoCRM\Client\AmoCRMApiClient;
use App\Models\Contact;
use League\OAuth2\Client\Token\AccessTokenInterface;

trait SaveContactsTraits
{

    private function saveContact(int $userId, AccessTokenInterface $token, AmoCRMApiClient $client)
    {
        $domain = $client->getOAuthClient()->getAccountDomain($token)->getDomain();
        $contactsService = $client->setAccessToken($token)->setAccountBaseDomain($domain)->contacts();

        try {
            $contactsCollection = $contactsService->get();
            while (true) {
                foreach ($contactsCollection as $contact) {
                    $customFields = $contact->getCustomFieldsValues();
                    if (isset($customFields)) {
                        $emails = $customFields->getBy('fieldCode', 'EMAIL');
                        if (isset($emails)) {
                            $emails = $emails->getValues();
                        } else {
                            continue;
                        }
                    } else {
                        continue;
                    }

                    if (isset($emails)) {
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
                $contactsCollection = $contactsService->nextPage($contactsCollection);
            }

        } catch (\AmoCRM\Exceptions\AmoCRMApiNoContentException $e) {
            return;
        } catch (\AmoCRM\Exceptions\AmoCRMApiPageNotAvailableException $e) {
            return;
        }

    }

}