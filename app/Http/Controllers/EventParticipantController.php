<?php

namespace App\Http\Controllers;

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
    public function index(Event $event)
    {
        $participants = $event->participants;

        return ParticipantResource::collection($participants);
    }

    /**
     * Store a newly created resource in storage.
     */
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
    public function destroy(Event $event, Participant $participant)
    {
        $this->authorize('manageParticipants', $event);
        
        $event->participants()->detach($participant);

        return response()->noContent();
    }
}
