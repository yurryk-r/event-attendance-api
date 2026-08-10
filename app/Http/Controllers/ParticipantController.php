<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

use App\Http\Requests\StoreParticipantRequest;
use App\Http\Requests\UpdateParticipantRequest;
use App\Http\Resources\ParticipantResource;
use App\Models\Participant;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        path: '/participants',
        operationId: 'getParticipants',
        tags: ['Participants'],
        summary: 'List participants',
        description: 'Returns a list of all participants. Requires authentication.',
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of participants',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(
                                ref: '#/components/schemas/Participant'
                            )
                        )
                    ]
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
        $this->authorize('viewAny', Participant::class);

        return ParticipantResource::collection(Participant::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    #[OA\Post(
        path: '/participants',
        operationId: 'createParticipant',
        tags: ['Participants'],
        summary: 'Create participant',
        description: 'Creates a new participant. Requires manager or administrator role.',
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['first_name', 'last_name', 'email'],
                properties: [
                    new OA\Property(
                        property: 'first_name',
                        type: 'string',
                        example: 'John'
                    ),
                    new OA\Property(
                        property: 'last_name',
                        type: 'string',
                        example: 'Doe'
                    ),
                    new OA\Property(
                        property: 'email',
                        type: 'string',
                        format: 'email',
                        example: 'john.doe@example.com'
                    )
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Participant created',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/Participant'
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
    public function store(StoreParticipantRequest  $request)
    {
        $this->authorize('create', Participant::class);

        $participant = Participant::create($request->validated());

        return (new ParticipantResource($participant))
                ->response()
                ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    #[OA\Get(
        path: '/participants/{participant}',
        operationId: 'getParticipant',
        tags: ['Participants'],
        summary: 'Get participant',
        description: 'Returns a single participant. Requires manager or administrator role.',
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'participant',
                description: 'Participant ID',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
                example: 1
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Participant retrieved',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/Participant'
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
                description: 'Participant not found'
            )
        ]
    )]
    public function show(Participant $participant)
    {
        $this->authorize('view', $participant);
        
        return new ParticipantResource($participant);        
    }

    /**
     * Update the specified resource in storage.
     */
    #[OA\Put(
        path: '/participants/{participant}',
        operationId: 'updateParticipant',
        tags: ['Participants'],
        summary: 'Update participant',
        description: 'Updates an existing participant. Requires manager or administrator role.',
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'participant',
                description: 'Participant ID',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
                example: 1
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['first_name', 'last_name', 'email'],
                properties: [
                    new OA\Property(
                        property: 'first_name',
                        type: 'string',
                        example: 'John'
                    ),
                    new OA\Property(
                        property: 'last_name',
                        type: 'string',
                        example: 'Smith'
                    ),
                    new OA\Property(
                        property: 'email',
                        type: 'string',
                        format: 'email',
                        example: 'john.smith@example.com'
                    )
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Participant updated',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/Participant'
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
                description: 'Participant not found'
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error'
            )
        ]
    )]
    #[OA\Patch(
        path: '/participants/{participant}',
        operationId: 'patchParticipant',
        tags: ['Participants'],
        summary: 'Partially update participant',
        description: 'Partially updates an existing participant. Requires manager or administrator role.',
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'participant',
                description: 'Participant ID',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
                example: 1
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: 'first_name',
                        type: 'string',
                        example: 'John'
                    ),
                    new OA\Property(
                        property: 'last_name',
                        type: 'string',
                        example: 'Smith'
                    ),
                    new OA\Property(
                        property: 'email',
                        type: 'string',
                        format: 'email',
                        example: 'john.smith@example.com'
                    )
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Participant updated',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'data',
                            ref: '#/components/schemas/Participant'
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
                description: 'Participant not found'
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error'
            )
        ]
    )]
    public function update(UpdateParticipantRequest $request, Participant $participant)
    {        
        $this->authorize('update', $participant);

        $participant->update($request->validated());

        return new ParticipantResource($participant);
    }

    /**
     * Remove the specified resource from storage.
     */
    #[OA\Delete(
        path: '/participants/{participant}',
        operationId: 'deleteParticipant',
        tags: ['Participants'],
        summary: 'Delete participant',
        description: 'Deletes an existing participant. Requires manager or administrator role.',
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'participant',
                description: 'Participant ID',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
                example: 1
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Participant deleted'
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
                description: 'Participant not found'
            )
        ]
    )]
    public function destroy(Participant $participant)
    {
        $this->authorize('delete', $participant);

        $participant->delete();

        return response()->noContent();
    }
}
