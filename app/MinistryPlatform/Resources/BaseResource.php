<?php

namespace MinistryPlatform\Resources;

use MinistryPlatform\Http\Client;

class BaseResource {

    protected $client;
    protected $table;

    public function __construct(Client $client) {
        $this->client = $client;
    }

    /**
     * @param array $attributes
     * @return mixed
     *
     * Create a new model (and optionally fill it) without saving
     */
    public function model($attributes = []) {
        $table_name = $this->getTableName();
        $class_name = '\\App\\MinistryPlatform\\Models\\' . str_singular($table_name);

        return new $class_name($this->client, $attributes);
    }

    /**
     * @param array $attributes
     * @return mixed
     *
     * Create a new model, fill it, and then save
     */
    public function create($attributes = []) {
        return $this->model($attributes)->save();
    }

    /**
     * @param $id
     * @return mixed
     *
     * Find the resource by ID and return a model
     */
    public function find($id) {
        $response = $this->client->get($this->getBaseEndpoint() . '/' . $id);

        return $this->model($response->getData());

    }

    protected function getBaseEndpoint() {
        return 'tables/' . $this->getTableName();
    }

    private function getTableName() {
        return $this->table ?: (new \ReflectionClass($this))->getShortName();
    }

}