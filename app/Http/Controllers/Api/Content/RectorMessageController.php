<?php

namespace App\Http\Controllers\Api\Content;

use Illuminate\Http\Request;
use App\Models\RectorMessage;
use App\Http\Controllers\Controller;
use App\Http\Resources\Content\RectorMessageResource;

class RectorMessageController extends Controller
{
    public function index() {
        $data = new RectorMessageResource(RectorMessage::latest()->first());

        return response()->json($data);
    }
}
