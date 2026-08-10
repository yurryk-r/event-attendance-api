<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'LoginResponse',
    description: 'Successful login response'
)]
class LoginResponse
{
    #[OA\Property(
        property: 'token',
        type: 'string',
        example: '1|8b3f7d9c5e6a4b2c'
    )]
    public string $token;

    #[OA\Property(
        property: 'user',
        ref: '#/components/schemas/User'
    )]
    public object $user;
}