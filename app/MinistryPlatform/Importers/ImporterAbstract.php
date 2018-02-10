<?php

namespace App\MinistryPlatform\Importers;

use App\MinistryPlatform\Client;

abstract class ImporterAbstract {

    protected $client;

    public function __construct(Client $client) {
        $this->client = $client;
    }

    public abstract function import();

}