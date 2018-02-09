<?php

namespace App\MinistryPlatform;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use kamermans\OAuth2\GrantType\PasswordCredentials;
use kamermans\OAuth2\OAuth2Middleware;

class Client {

    private $auth_client;
    private $client;

    private $domain;
    private $username;
    private $password;

    public function __construct($domain, $username, $password) {
        $this->domain = $domain;
        $this->username = $username;
        $this->password = $password;

        $this->client = $this->setupClient();
    }

    private function setupClient() {

        $this->auth_client = new GuzzleClient([
            'base_uri' => $this->getAuthEndpoint(),
        ]);

        $grant_type = new PasswordCredentials($this->auth_client, [
            'client_id' => 'Platform.Web.Services',
            'username'  => $this->username,
            'password'  => $this->password,
        ]);

        $oauth = new OAuth2Middleware($grant_type);
        $oauth->setTokenPersistence(new TokenPersistence);

        $stack = HandlerStack::create();
        $stack->push($oauth);

        $client = new GuzzleClient([
            'base_uri' => 'https://my.faithpromise.org/ministryplatformapi/',
            'handler'  => $stack,
            'auth'     => 'oauth',
        ]);

        return $client;

    }

    public function getAuthEndpoint() {
        return 'https://' . $this->domain . '/ministryplatform/oauth/token';
    }

    public function get($endpoint, $parameters = []) {

        $response = $this->client->get($endpoint, $parameters);
        $content = $response->getBody()->getContents();

        return json_decode($content);

    }

}
