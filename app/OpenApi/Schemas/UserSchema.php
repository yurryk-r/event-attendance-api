<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'User',
    description: 'User resource'
)]
class UserSchema
{
    #[OA\Property(example: 1)]
    public int $id;

    #[OA\Property(example: 'User Name')]
    public string $name;

    #[OA\Property(
        example: 'user@example.com',
        format: 'email'
    )]
    public string $email;

    #[OA\Property(example: 'user')]
    public ?string $role = null;
}