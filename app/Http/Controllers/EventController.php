<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        path: '/events',
        operationId: 'getEvents',
        tags: ['Events'],
        summary: 'List events',
        description: 'Returns a list of all events with their creators.',
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of events',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        ref: '#/components/schemas/Event'
                    )
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthenticated'
            )
        ]
    )]
    public function index()
    {
        return EventResource::collection(
            Event::with('creator')->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    #[OA\Post(
        path: '/events',
        operationId: 'createEvent',
        tags: ['Events'],
        summary: 'Create event',
        description: 'Creates a new event. Requires manager or administrator role.',
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['title', 'starts_at'],
                properties: [
                    new OA\Property(
                        property: 'title',
                        type: 'string',
                        example: 'Laravel Conference'
                    ),
                    new OA\Property(
                        property: 'description',
                        type: 'string',
                        nullable: true,
                        example: 'Annual Laravel conference'
                    ),
                    new OA\Property(
                        property: 'starts_at',
                        type: 'string',
                        format: 'date-time',
                        example: '2026-08-20T09:00:00Z'
                    ),
                    new OA\Property(
                        property: 'ends_at',
                        type: 'string',
                        format: 'date-time',
                        nullable: true,
                        example: '2026-08-20T17:00:00Z'
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Event created successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/Event'
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthenticated'
            ),
            new OA\Response(
                response: 403,
                description: 'Forbidden'
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error'
            )
        ]
    )]
    public function store(StoreEventRequest $request)
    {
        $this->authorize('create', Event::class);
        
        $event = Event::create([
                ...$request->validated(),
                'created_by' => auth()->id(),
        ]);

        return (new EventResource($event))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    #[OA\Get(
        path: '/events/{event}',
        operationId: 'getEvent',
        tags: ['Events'],
        summary: 'Get event',
        description: 'Returns a single event.',
        parameters: [
            new OA\Parameter(
                name: 'event',
                description: 'Event ID',
                in: 'path',
                required: true,
                example: 1
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Event details',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/Event'
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Event not found'
            )
        ]
    )]
    public function show(Event $event)
    {
        $event->load('creator');

        return new EventResource($event);
    }

    /**
     * Update the specified resource in storage.
     */
    #[OA\Put(
        path: '/events/{event}',
        operationId: 'updateEvent',
        tags: ['Events'],
        summary: 'Update event',
        description: 'Replaces an existing event. Requires manager or administrator role.',
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'event',
                description: 'Event ID',
                in: 'path',
                required: true,
                example: 1
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['title', 'starts_at'],
                properties: [
                    new OA\Property(
                        property: 'title',
                        type: 'string',
                        example: 'Updated Laravel Conference'
                    ),
                    new OA\Property(
                        property: 'description',
                        type: 'string',
                        nullable: true,
                        example: 'Updated description'
                    ),
                    new OA\Property(
                        property: 'starts_at',
                        type: 'string',
                        format: 'date-time',
                        example: '2026-08-21T09:00:00Z'
                    ),
                    new OA\Property(
                        property: 'ends_at',
                        type: 'string',
                        format: 'date-time',
                        nullable: true,
                        example: '2026-08-21T17:00:00Z'
                    ),
                    new OA\Property(
                        property: 'created_by',
                        type: 'integer',
                        nullable: true,
                        example: 1
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Event updated successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/Event'
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthenticated'
            ),
            new OA\Response(
                response: 403,
                description: 'Forbidden'
            ),
            new OA\Response(
                response: 404,
                description: 'Event not found'
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error'
            )
        ]
    )]
    #[OA\Patch(
        path: '/events/{event}',
        operationId: 'patchEvent',
        tags: ['Events'],
        summary: 'Partially update event',
        description: 'Partially updates an existing event. Requires manager or administrator role.',
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'event',
                description: 'Event ID',
                in: 'path',
                required: true,
                example: 1
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: 'title',
                        type: 'string',
                        example: 'Updated Laravel Conference'
                    ),
                    new OA\Property(
                        property: 'description',
                        type: 'string',
                        nullable: true,
                        example: 'Updated description'
                    ),
                    new OA\Property(
                        property: 'starts_at',
                        type: 'string',
                        format: 'date-time',
                        example: '2026-08-21T09:00:00Z'
                    ),
                    new OA\Property(
                        property: 'ends_at',
                        type: 'string',
                        format: 'date-time',
                        nullable: true,
                        example: '2026-08-21T17:00:00Z'
                    ),
                    new OA\Property(
                        property: 'created_by',
                        type: 'integer',
                        nullable: true,
                        example: 1
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Event updated successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/Event'
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthenticated'
            ),
            new OA\Response(
                response: 403,
                description: 'Forbidden'
            ),
            new OA\Response(
                response: 404,
                description: 'Event not found'
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error'
            )
        ]
    )]
    public function update(UpdateEventRequest $request, Event $event)
    {
        $this->authorize('update', $event);

        $event->update($request->validated());

        return new EventResource($event);        
    }

    /**
     * Remove the specified resource from storage.
     */
    #[OA\Delete(
        path: '/events/{event}',
        operationId: 'deleteEvent',
        tags: ['Events'],
        summary: 'Delete event',
        description: 'Deletes an existing event. Requires manager or administrator role.',
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'event',
                description: 'Event ID',
                in: 'path',
                required: true,
                example: 1
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Event deleted successfully'
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthenticated'
            ),
            new OA\Response(
                response: 403,
                description: 'Forbidden'
            ),
            new OA\Response(
                response: 404,
                description: 'Event not found'
            )
        ]
    )]
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        $event->delete();

        return response()->noContent();
    }
}
