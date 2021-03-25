<?php

namespace App\DTOs;

class OAuthDataDTO extends DTO
{
    protected string $token_type;
    protected string $expires_in;
    protected string $access_token;
    protected string $refresh_token;

    public function __construct(
        string $tokenType,
        string $expiresIn,
        string $accessToken,
        string $refreshToken
    ) {
        $this->token_type = $tokenType;
        $this->expires_in = $expiresIn;
        $this->access_token = $accessToken;
        $this->refresh_token = $refreshToken;
    }
}
