<?php

// Using https://github.com/kamermans/guzzle-oauth2-subscriber

namespace App\MinistryPlatform;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use kamermans\OAuth2\GrantType\PasswordCredentials;
use kamermans\OAuth2\OAuth2Middleware;

class Client {

    private $auth_client;
    private $client;
    private $discovery_doc;

    private $domain;
    private $client_id;
    private $client_secret;
    private $username;
    private $password;

    public function __construct($domain, $client_id, $client_secret, $username = null, $password = null) {
        $this->domain = $domain;
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->username = $username;
        $this->password = $password;

        $this->client = $this->setupClient();
    }

    private function setupClient() {

        $this->auth_client = new GuzzleClient([
            'base_uri' => $this->getTokenEndpoint(),
        ]);

        $grant_type = new PasswordCredentials($this->auth_client, [
            'client_id'     => $this->client_id,
            'client_secret' => $this->client_secret,
            'username'      => $this->username,
            'password'      => $this->password,
            'scope'         => 'http://www.thinkministry.com/dataplatform/scopes/all',
            'grant_type'    => 'password',
        ]);

        $oauth = new OAuth2Middleware($grant_type);
        $oauth->setTokenPersistence(new TokenPersistence);

        $stack = HandlerStack::create();
        $stack->push($oauth);

        $client = new GuzzleClient([
            'base_uri' => 'https://' . $this->domain . '/ministryplatformapi/',
            'auth'     => 'oauth',
            'handler'  => $stack,
        ]);

        return $client;

    }

    public function get($endpoint, $parameters = []) {

        $response = $this->client->get($endpoint, [
            'query' => $parameters,
        ]);
        $content = $response->getBody()->getContents();

        return json_decode($content);

    }

    public function post($endpoint, $parameters = []) {
        $response = $this->client->post($endpoint, [
            'form_params' => $parameters,
        ]);
        $content = $response->getBody()->getContents();

        return json_decode($content);
    }

    private function discover() {

        if (!$this->discovery_doc) {
            $discover_client = new GuzzleClient();
            $response = $discover_client->get('https://' . $this->domain . '/ministryplatform/oauth');
            $content = $response->getBody()->getContents();
            $this->discovery_doc = json_decode($content);
        }

        return $this->discovery_doc;
    }

    private function getTokenEndpoint() {
        return $this->discover()->token_endpoint;
    }

}
