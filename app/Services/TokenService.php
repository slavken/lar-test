<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class TokenService
{
    private array $token;
    protected string $email;
    protected string $password;

    function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;

        $this->response();
    }

    function tokenType()
    {
        return $this->token['token_type'];
    }

    function expiresIn()
    {
        return $this->token['expires_in'];
    }

    function accessToken()
    {
        return $this->token['access_token'];
    }

    function refreshToken()
    {
        return $this->token['refresh_token'];
    }

    function response()
    {
        $response = Http::asForm()->post(url('/oauth/token'), [
            'grant_type' => 'password',
            'client_id' => Config::get('passport.personal_access_client.id'),
            'client_secret' => Config::get('passport.personal_access_client.secret'),
            'username' => $this->email,
            'password' => $this->password,
            'scope' => '',
        ]);

        $this->token = $response->json();
    }
}