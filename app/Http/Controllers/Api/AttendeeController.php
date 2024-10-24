<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AttendeeResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    use CanLoadRelationships;

    private array $relations = ['user']; 

    public function index(Event $event)
    {
        $attendees = $this->loadRelationship(
             $event->attendees()->latest()
        );

        return AttendeeResource::collection(
            $attendees->paginate()
        );
    }

   
    public function store(Request $request, Event $event)
    {
        $attendee =$this->loadRelationship(
             $event->attendees()->create([
            'user_is' => 1
            ])
        );

        return new AttendeeResource($attendee);
    }

  
    public function show(Event $event, Attendee $attendee)
    {
        return new AttendeeResource(
            $this->loadRelationships($attendee)
        );
    }
  
    public function destroy(Event $event, Attendee $attendee)
    {

        $attendee->delete();
        return response(status:204);
    }
}