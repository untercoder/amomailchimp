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

    public function updateContact(int $owner, array $data):void {
        $contactsId = [];
        $contacts = Contact::where('contact_id', '=', $data[0]['id'])->get();
        foreach ($contacts as $contact) {
            $contactsId[] = $contact->id;
        }

        $count = 0;

        foreach ($data[0]['custom_fields'][0]['values'] as $email) {
            $idContact = $contactsId[$count];
            $contact = Contact::where('id', '=', $idContact)->first();
            if(isset($contact)) {
                $oldEmail = $contact->email;
                $contact->email = $email['value'];
                $contact->name = $data[0]['name'];
                $contact->save();
                $this->updateContactFromMailchimp($email['value'], $data[0]['name'], $oldEmail);
            } else {
                Contact::create([
                    'owner' => $owner,
                    'contact_id' => $data[0]['id'],
                    'name' => $data[0]['name'],
                    'email' => $email['value'],
                ]);
                $this->updateContactFromMailchimp($email['value'], $data[0]['name']);
            }
            ++$count;
        }
    }

    public function updateContactFromMailchimp($email, $name, $oldHash = null): void {
        if (isset($oldHash)) {
            $has = md5($oldHash);
        } else {
            $has = md5($email);
        }
        $this->clientMailchimp->lists->setListMember(self::MAILCHIMP_ID, $has, [
            'email_address' => $email,
            'status_if_new' => 'subscribed',
            'merge_fields' => [
                'FNAME' => $name,
            ],
        ]);
    }

}