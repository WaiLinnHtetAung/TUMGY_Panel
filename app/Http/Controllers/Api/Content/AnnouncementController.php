<?php

namespace App\Http\Controllers\Api\Content;

use App\Http\Controllers\Controller;
use App\Http\Resources\Content\AnnouncementResource;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(Request $request) {
        $count = $request->get('count', null);
        $query = Announcement::orderBy('created_at', 'desc');
        $announcements = $count ? $query->limit($count)->get() : $query->get();

        return response()->json(AnnouncementResource::collection($announcements));
    }

    public function show(Announcement $announcement) {
        return response()->json(new AnnouncementResource($announcement));
    }
}
