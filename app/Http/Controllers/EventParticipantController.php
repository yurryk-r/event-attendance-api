<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

use App\Http\Requests\StoreEventParticipantRequest;
use App\Http\Resources\ParticipantResource;
use App\Models\Event;
use App\Models\Participant;
use Illuminate\Http\Request;

class EventParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        path: '/events/{event}/participants',
        operationId: 'getEventParticipants',
        tags: ['Event Participants'],
        summary: 'List event participants',
        description: 'Returns all participants assigned to an event.',
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'event',
                description: 'Event ID',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
                example: 1
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Participants retrieved successfully',
                content: new OA\JsonContent(
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
                response: 404,
                description: 'Event not found'
            )
        ]
    )]
    public function index(Event $event)
    {
        $participants = $event->participants;

        return ParticipantResource::collection($participants);
    }

    /**
     * Store a newly created resource in storage.
     */
    #[OA\Post(
        path: '/events/{event}/participants',
        operationId: 'assignEventParticipant',
        tags: ['Event Participants'],
        summary: 'Assign participant to event',
        description: 'Assigns a participant to an event. Requires manager or administrator role.',
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'event',
                description: 'Event ID',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
                example: 1
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['participant_id'],
                properties: [
                    new OA\Property(
                        property: 'participant_id',
                        type: 'integer',
                        example: 1
                    )
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 204,
                description: 'Participant assigned successfully'
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
    public function store(StoreEventParticipantRequest $request, Event $event)
    {
        $this->authorize('manageParticipants', $event);

        $event->participants()->syncWithoutDetaching([
            $request->validated('participant_id')
        ]);

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    #[OA\Delete(
        path: '/events/{event}/participants/{participant}',
        operationId: 'removeEventParticipant',
        tags: ['Event Participants'],
        summary: 'Remove participant from event',
        description: 'Removes a participant from an event. Requires manager or administrator role.',
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'event',
                description: 'Event ID',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
                example: 1
            ),
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
                description: 'Participant removed successfully'
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
                description: 'Event or participant not found'
            )
        ]
    )]
    public function destroy(Event $event, Participant $participant)
    {
        $this->authorize('manageParticipants', $event);
        
        $event->participants()->detach($participant);

        return response()->noContent();
    }
}
