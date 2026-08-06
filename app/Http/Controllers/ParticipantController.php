<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreParticipantRequest;
use App\Http\Requests\UpdateParticipantRequest;
use App\Http\Resources\ParticipantResource;
use App\Models\Participant;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Participant::class);

        return ParticipantResource::collection(Participant::all());
    }

    /**
     * Store a newly created resource in storage.
     */
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
    public function show(Participant $participant)
    {
        $this->authorize('view', $participant);
        
        return new ParticipantResource($participant);        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateParticipantRequest $request, Participant $participant)
    {        
        $this->authorize('update', $participant);

        $participant->update($request->validated());

        return new ParticipantResource($participant);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Participant $participant)
    {
        $this->authorize('delete', $participant);

        $participant->delete();

        return response()->noContent();
    }
}
