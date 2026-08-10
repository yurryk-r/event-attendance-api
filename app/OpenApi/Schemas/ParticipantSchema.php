<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Participant',
    description: 'Participant resource'
)]
class ParticipantSchema
{
    #[OA\Property(
        property: 'id',
        type: 'integer',
        example: 1
    )]
    public int $id;

    #[OA\Property(
        property: 'first_name',
        type: 'string',
        example: 'John'
    )]
    public string $first_name;

    #[OA\Property(
        property: 'last_name',
        type: 'string',
        example: 'Doe'
    )]
    public string $last_name;

    #[OA\Property(
        property: 'email',
        type: 'string',
        format: 'email',
        example: 'john.doe@example.com'
    )]
    public string $email;
}