<?php

namespace App\Http\Controllers\Api\Content;

use App\Models\NewEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Content\NewEventResource;

class NewEventController extends Controller
{
    public function index(Request $request) {
        $count = $request->get('count', null);
        $query = NewEvent::orderBy('created_at', 'desc');
        $new_events = $count ? $query->limit($count)->get() : $query->get();


        return response()->json(NewEventResource::collection($new_events));
    }

    public function show(NewEvent $newEvent) {
        return response()->json(new NewEventResource($newEvent));
    }
}
