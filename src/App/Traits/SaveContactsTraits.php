<?php

namespace App\Traits;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Models\ContactModel;
use App\Models\Contact;
use Error;
use League\OAuth2\Client\Token\AccessTokenInterface;
use MailchimpMarketing\ApiClient;

trait SaveContactsTraits
{

    private function saveContact(int $userId, AccessTokenInterface $token)
    {
        $domain = $this->clientAmo->getOAuthClient()->getAccountDomain($token)->getDomain();
        $contactsService = $this->clientAmo->setAccessToken($token)->setAccountBaseDomain($domain)->contacts();

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
                    $this->saveContactMailchimp($contact);
                }
                $contactsCollection = $contactsService->nextPage($contactsCollection);
            }

        } catch (\AmoCRM\Exceptions\AmoCRMApiNoContentException $e) {
            return;
        } catch (\AmoCRM\Exceptions\AmoCRMApiPageNotAvailableException $e) {
            return;
        }

    }

    private function saveContactMailchimp(ContactModel $contact){
        try {
            $emails = $contact->getCustomFieldsValues()->getBy('field_code', 'EMAIL')->getValues();
        } catch(Error $e) {
            return;
        }
        foreach($emails as $email) {
                $this->clientMailchimp->lists->setListMember(self::MAILCHIMP_ID, md5($email->getValue()), [
                    'email_address' => $email->getValue(),
                    'status_if_new' => 'subscribed',
                    'merge_fields' => [
                        'FNAME' => $contact->getName(),
                    ],
                ]);
        }
    }

}