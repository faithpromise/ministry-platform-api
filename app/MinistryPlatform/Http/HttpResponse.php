<?php

namespace MinistryPlatform\Http;

use GuzzleHttp\Client as GuzzleClient;

class HttpResponse {

    private $client;
    private $response;

    public function __construct(GuzzleClient $client) {
        $this->client = $client;
    }

    public function get($endpoint, $parameters = []) {
        $this->response = $this->client->get($endpoint, ['query' => $parameters,]);

        return $this;
    }

    public function post($endpoint, $parameters = []) {
        $this->response = $this->client->post($endpoint, ['form_params' => $parameters,]);

        return $this;
    }

    public function postJson($endpoint, $parameters = []) {
        $this->response = $this->client->post($endpoint, ['json' => $parameters,]);

        return $this;
    }

    public function getData() {
        return json_decode($this->response->getBody()->getContents(), true);
    }

    /**
     * @return array|null
     * @throws \Exception
     *
     * There are inconsistencies with the response for single items. Sometimes the item is nested two levels deep and sometimes it's not.
     */
    public function getSingle() {

        $data = $this->getData()[0];

        if (empty($data))
            return null;

        if ($this->isAssociativeArray($data))
            return $data;

        if (empty($data[0]))
            return null;

        if ($this->isAssociativeArray($data[0]))
            return $data[0];

        throw(new \Exception('Failed to retrieve single item from response.'));

    }

    public function getResponse() {
        return $this->response;
    }

    private function isAssociativeArray($array) {
        return count(array_filter(array_keys($array), 'is_string')) > 0;
    }

}