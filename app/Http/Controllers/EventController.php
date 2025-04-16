<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Event;
use App\Jobs\SendInvites;
use App\Enums\EventStatus;
use App\Imports\InviteesImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Resources\EventCollection;
use App\Http\Requests\Event\AttendRequest;
use App\Http\Requests\Event\CreateEventRequest;
use App\Http\Requests\Event\PreviewEventRequest;
use App\Http\Requests\Event\SendMoreInvitesRequest;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response([
            'events' => new EventCollection(Event::orderBy('created_at', 'desc')->paginate())
        ]);
    }

    /**
     * Store a new event and send invites.
     */
    public function store(CreateEventRequest $request)
    {
        try {
            $event = auth()->user()->events()->create($request->all());
            
            Excel::import(new InviteesImport($event->id), $request->file('invitees_file'));
    
            SendInvites::dispatch($event);

            return response([
                'message' => __("Invites are being sent now, you can close this page")
            ]);
        } catch(Exception $e) {
            info($e->getMessage());
            return response([
                'message' => __("An error occured, please try again")
            ], 400);
        }

    }

    public function sendMoreInvites(SendMoreInvitesRequest $request, Event $event)
    {
        try {            
            Excel::import(new InviteesImport($event->id), $request->file('invitees_file'));
    
            SendInvites::dispatch($event);

            return response([
                'message' => __("Invites are being sent now")
            ]);
        } catch(Exception $e) {
            info($e->getMessage());
            return response([
                'message' => __("An error occured, please try again")
            ], 400);
        }
    }

    public function preview(PreviewEventRequest $request)
    {
        $event = Event::make($request->all());
        $event->createCustomWeddingCard();

        return response([
            'message' => __("Form sent, you can preview image now"),
            'src' => $event->customWeddingCard->toJpeg()->toDataUri()
        ]);
    }

    public function start(Event $event)
    {
        if($event->status != EventStatus::NOT_STARTED) {
            return response([
                'message' => __("Event already started")
            ], 400);
        }

        $event->status = EventStatus::IN_PROGRESS;
        $event->save();

        return response([
            'message' => __("Event started successfully")
        ]);
    }

    public function end(Event $event)
    {
        if($event->status != EventStatus::IN_PROGRESS) {
            return response([
                'message' => __("Can't end event")
            ], 400);
        }

        $event->status = EventStatus::FINISHED;
        $event->save();


        return response([
            'message' => __("Event ended successfully")
        ]);
    }

    public function attend(Event $event, AttendRequest $request)
    {
        if($event->status == EventStatus::NOT_STARTED) {
            return response([
                'message' => __("Event not started yet")
            ], 400);
        }

        if($event->status == EventStatus::FINISHED) {
            return response([
                'message' => __("Event ended")
            ], 400);
        }

        $qrCode = $request->qr_code;

        $invitee = $event->invitees()->where('qr_token', $qrCode)->first();

        if(!$invitee) {
            return response([
                'message' => __("Invalid QR code")
            ], 400);
        }

        if($invitee->attended_at) {
            return response([
                'message' => __("This user has already attended")
            ], 400);
        }

        $invitee->attended_at = now();
        $invitee->save();

        return response([
            'message' => __("Invitee marked as attended successfully")
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
