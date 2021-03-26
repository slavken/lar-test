<?php

namespace App\Services;

use App\DTOs\OAuthDataDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;

class TokenService
{
    private array $token;
    protected string $email;
    protected string $password;

    function getToken(FormRequest $request)
    {
        $this->email = $request->email;
        $this->password = $request->password;

        $this->fromResponse();
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

    function fromResponse()
    {
        $response = Http::asForm()->post(url('/oauth/token'), [
            'grant_type' => 'password',
            'client_id' => env('PASSPORT_PASSWORD_GRANT_CLIENT_ID'),
            'client_secret' => env('PASSPORT_PASSWORD_GRANT_CLIENT_SECRET'),
            'username' => $this->email,
            'password' => $this->password,
            'scope' => '',
        ]);

        $this->token = $response->json();
    }

    function toResponse()
    {
        return (new OAuthDataDTO(
            $this->tokenType(),
            $this->expiresIn(),
            $this->accessToken(),
            $this->refreshToken()
        ))->jsonSerialize();
    }
}