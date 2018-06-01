<?php

namespace App\MinistryPlatform\Importers;

use App\MinistryPlatform\Http\Client;

abstract class ImporterAbstract {

    protected $client;

    public function __construct(Client $client) {
        $this->client = $client;
    }

    public abstract function import();

    protected function buildSelectQuery($select_columns) {

        $select = [];

        foreach ($select_columns as $table => $fields) {
            $select[] = implode(', ', preg_filter('/^/', $table . '.', $fields));
        }

        return implode(', ', $select);
    }

}