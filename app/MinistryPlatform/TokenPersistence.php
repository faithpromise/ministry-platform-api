<?php

namespace App\MinistryPlatform;

use Illuminate\Support\Facades\Cache;
use kamermans\OAuth2\Persistence\TokenPersistenceInterface;
use kamermans\OAuth2\Token\TokenInterface;

class TokenPersistence implements TokenPersistenceInterface {

    const TOKEN_NAME = 'mp_api_token';

    /**
     * Restore the token data into the give token.
     *
     * @param TokenInterface $token
     *
     * @return TokenInterface Restored token
     */
    public function restoreToken(TokenInterface $token) {
        $data = @json_decode(Cache::get(self::TOKEN_NAME, null), true);

        return is_array($data) ? $token->unserialize($data) : null;
    }

    /**
     * Save the token data.
     *
     * @param TokenInterface $token
     */
    public function saveToken(TokenInterface $token) {
        Cache::put(self::TOKEN_NAME, json_encode($token->serialize()), 10);
    }

    /**
     * Delete the saved token data.
     */
    public function deleteToken() {
        Cache::forget(self::TOKEN_NAME);
    }

}