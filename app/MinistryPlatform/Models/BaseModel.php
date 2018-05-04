<?php

namespace MinistryPlatform\Models;

use MinistryPlatform\Http\Client;

class BaseModel {

    public $attributes = [];
    protected $table;
    protected $primary_key_field;
    private $client;

    public function __construct(Client $client, $attributes = []) {
        $this->client = $client;

        $this->fill($attributes);

        return $this;
    }

    public function save() {
        $pk = $this->getPrimaryKey();
        $endpoint = $this->getBaseEndpoint() . ($pk ? '/' . $pk : '');

        $result = $this->client->postJson($endpoint, [$this->attributes]);

        $this->fill($result->getSingle());

        return $this;
    }

    public function fill($attributes) {
        foreach ($attributes as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function getPrimaryKey() {
        return array_key_exists($this->getPrimaryKeyField(), $this->attributes) ? $this->attributes[$this->getPrimaryKeyField()] : null;
    }

    public function __set($name, $value) {

        $method = 'set' . $name;

        if (method_exists($this, $method))
            return $this->{$method}($value);

        $this->attributes[$name] = $value;
    }

    public function __get($name) {

        $method = 'get' . $name;

        if (method_exists($this, $method))
            return $this->{$method}($name);

        if (array_key_exists($name, $this->attributes))
            return $this->attributes[$name];

        return null;
    }

    protected function getBaseEndpoint() {
        return 'tables/' . $this->getTableName();
    }

    private function getPrimaryKeyField() {
        return $this->primary_key_field ?: str_singular($this->getTableName()) . '_ID';
    }

    private function getTableName() {
        return $this->table ?: str_plural((new \ReflectionClass($this))->getShortName());
    }

}