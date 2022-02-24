<?php

namespace App\Traits;

use App\Models\Contact;

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
       }
    }

    public function updateContact(int $owner, array $data):void {
        print_r($data['custom_fields']);
        $this->deleteContact($data);
        $this->addContact($owner, $data);
    }

    public function deleteContact(array $data):void {
        $contactId = $data[0]['id'];
        $contact = Contact::where('contact_id', '=', $contactId)->first();
        $contact->delete();
    }

}