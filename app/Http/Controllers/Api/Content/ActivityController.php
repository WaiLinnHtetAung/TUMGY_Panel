<?php

namespace App\Http\Controllers\Api\Content;

use App\Http\Resources\Content\ActivityResource;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
    public function index(Request $request) {

        $data = ActivityResource::collection(Activity::with('images')->orderBy('created_at', 'desc')->get());

        return response()->json($data);
    }

    public function show(Activity $activity) {
        return response()->json(new ActivityResource($activity));
    }
}
