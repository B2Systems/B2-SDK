<?php

namespace B2Systems\B2\Actions;

use GuzzleHttp\Client;

trait ManagesTokens
{
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    public function refreshToken()
    {
        $http = new Client;

        $response = $http->post("$this->baseUrl/oauth/token", [
            'form_params' => [
                'grant_type' => 'refresh_token',
                'refresh_token' => $this->apiRefreshKey,
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'scope' => '',
            ]
        ]);

        return json_decode((string) $response->getBody(), true);
    }
}
