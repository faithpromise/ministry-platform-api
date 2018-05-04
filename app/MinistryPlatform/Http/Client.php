<?php

// Using https://github.com/kamermans/guzzle-oauth2-subscriber

namespace MinistryPlatform\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use kamermans\OAuth2\GrantType\PasswordCredentials;
use kamermans\OAuth2\OAuth2Middleware;

use MinistryPlatform\Resources\Contacts;
use MinistryPlatform\Resources\Group_Inquiries;
use MinistryPlatform\TokenPersistence;

/**
 * Class Client
 * @package MinistryPlatform
 *
 *
 * @method Contacts contacts()
 * @method Group_Inquiries groupInquiries()
 *
 */
class Client {

    private $auth_client;
    private $http_client;
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

        $this->http_client = $this->setupClient();
    }

    public static function getValidSubResources() {
        return [
            'contacts'        => Contacts::class,
            'groupInquiries' => Group_Inquiries::class,
        ];
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

    /**
     * @param $endpoint
     * @param array $parameters
     * @return HttpResponse
     */
    public function get($endpoint, $parameters = []) {
        return (new HttpResponse($this->http_client))->get($endpoint, $parameters);
    }

    /**
     * @param $endpoint
     * @param array $parameters
     * @return HttpResponse
     */
    public function post($endpoint, $parameters = []) {
        return (new HttpResponse($this->http_client))->post($endpoint, $parameters);
    }

    /**
     * @param $endpoint
     * @param array $parameters
     * @return HttpResponse
     */
    public function postJson($endpoint, $parameters = []) {
        return (new HttpResponse($this->http_client))->postJson($endpoint, $parameters);
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

    public function __call($name, $arguments) {
        if ((array_key_exists($name, $validSubResources = $this::getValidSubResources()))) {
            $className = $validSubResources[$name];
            $client = ($this instanceof Client) ? $this : $this->http_client;
            $class = new $className($client);
        } else {
            throw new \Exception("No method called $name available in " . __CLASS__);
        }

        return $class;
    }

}
