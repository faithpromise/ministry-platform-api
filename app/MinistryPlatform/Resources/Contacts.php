<?php

namespace App\MinistryPlatform\Resources;

use App\MinistryPlatform\Models\Contact;

class Contacts extends BaseResource {

    public function findByEmail($email) {

        $response = $this->client->get($this->getBaseEndpoint(), [
            '$Select' => "Contact_ID, First_Name, Last_Name",
            '$Filter' => "(Email_Address = '$email')",
        ]);

        $data = $response->getData();

        // this->client->Contact <---- makes model
        $model = $this->client;

    }

    /**
     * @param $first_name
     * @param $last_name
     * @param $email
     * @param null $phone
     * @return Contact|null
     * @throws \Exception
     */
    public function match($first_name, $last_name, $email, $phone = null) {

        $response = $this->client->postJson('procs/api_Common_FindMatchingContact', [
            '@FirstName'    => $first_name,
            '@LastName'     => $last_name,
            '@EmailAddress' => $email,
            '@Phone'        => $phone,
            '@RequireEmail' => 1,
        ]);

        $match = $response->getSingle();

        /** If no contact found, result will be an array containing one item - an empty array */
        return $match ? $this->model($match) : null;
    }

    /**
     * @param string $First_Name
     * @param string $Last_Name
     * @param string $Email_Address
     * @param string|null $Mobile_Phone
     * @return Contact|null
     * @throws \Exception
     */
    public function firstOrCreate($First_Name, $Last_Name, $Email_Address, $Mobile_Phone = null) {

        $contact = $this->match($First_Name, $Last_Name, $Email_Address, $Mobile_Phone);

        if (!$contact) {
            /** @var Contact $contact */
            $contact = $this->model();
            $contact->First_Name = $First_Name;
            $contact->Last_Name = $Last_Name;
            $contact->Email_Address = $Email_Address;
            $contact->Mobile_Phone = $Mobile_Phone;
            $contact->save();
        }

        return $contact;
    }

}