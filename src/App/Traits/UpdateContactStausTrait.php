<?php

namespace App\Traits;

use App\Models\Contact;
use GuzzleHttp\Exception\ClientException;
use MailchimpMarketing\ApiClient;

trait UpdateContactStausTrait
{
    public function addContact(int $owner, array $data):void {
       print_r($data['custom_fields']);
       foreach ($data[0]['custom_fields'][0]['values'] as $email) {
           Contact::create([
               'owner' => $owner,
               'contact_id' => $data[0]['id'],
               'name' => $data[0]['name'],
               'email' => $email['value'],
           ]);

           $this->updateContactFromMailchimp($email['value'], $data[0]['name']);
       }

    }

    public function updateContact(int $owner, array $data):void {
        $contactId = $data[0]['id'];
        $contacts = Contact::where('contact_id', '=', $contactId)->get();
        foreach ($contacts as $contact){
            $contact->delete();
        }
        $this->addContact($owner, $data);
    }

    public function deleteContact(array $data):void {
        $contactId = $data[0]['id'];
        $contacts = Contact::where('contact_id', '=', $contactId)->get();
        foreach ($contacts as $contact){
            $email = $contact->email;
            $contact->delete();
            $this->deleteContactFromMailchimp($email);
        }
    }

    public function deleteContactFromMailchimp(string $email){
        echo $email;
        try {
            $this->clientMailchimp->lists->deleteListMemberPermanent(self::MAILCHIMP_ID, md5($email));
        } catch(ClientException $e) {
            return;
        }
    }

    public function updateContactFromMailchimp($email, $name){
        echo $email;
        $this->clientMailchimp->lists->setListMember(self::MAILCHIMP_ID, md5($email), [
            'email_address' => $email,
            'status_if_new' => 'subscribed',
            'merge_fields' => [
                'FNAME' => $name,
            ],
        ]);
    }

}