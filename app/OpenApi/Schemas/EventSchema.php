<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Event',
    description: 'Event resource'
)]
class EventSchema
{
    #[OA\Property(
        property: 'id',
        type: 'integer',
        example: 1
    )]
    public int $id;

    #[OA\Property(
        property: 'title',
        type: 'string',
        example: 'Laravel Conference'
    )]
    public string $title;

    #[OA\Property(
        property: 'description',
        type: 'string',
        nullable: true,
        example: 'Annual Laravel conference'
    )]
    public ?string $description;

    #[OA\Property(
        property: 'starts_at',
        type: 'string',
        format: 'date-time',
        example: '2026-08-20T09:00:00Z'
    )]
    public string $starts_at;

    #[OA\Property(
        property: 'ends_at',
        type: 'string',
        format: 'date-time',
        example: '2026-08-20T17:00:00Z'
    )]
    public string $ends_at;

    #[OA\Property(
        property: 'created_at',
        type: 'string',
        format: 'date-time',
        example: '2026-08-08T10:00:00Z'
    )]
    public string $created_at;

    #[OA\Property(
        property: 'updated_at',
        type: 'string',
        format: 'date-time',
        example: '2026-08-08T10:00:00Z'
    )]
    public string $updated_at;

    #[OA\Property(
        property: 'created_by',
        type: 'integer',
        example: 1
    )]
    public int $created_by;

    #[OA\Property(
        property: 'creator',
        ref: '#/components/schemas/User'
    )]
    public object $creator;
}