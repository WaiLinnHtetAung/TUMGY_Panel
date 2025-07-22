<?php

namespace App\Http\Controllers\Api\Content;

use App\Mail\FeedbackMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function submitEmail(Request $request) {
        logger('eakdf');
        try {
            $mailData = [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
            ];

            Mail::to('wailinhtetaung007@gmail.com')->send(new FeedbackMail($mailData));

            return response()->json([
                'ok' => true,
            ]);
        } catch(\Exception $e) {
            logger($e);
            return response()->json([
                'ok' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
