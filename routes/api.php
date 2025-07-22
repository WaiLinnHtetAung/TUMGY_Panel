<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Thesis\ThesisController;
use App\Http\Controllers\Api\Edu\DepartmentController;
use App\Http\Controllers\Api\Content\ActivityController;
use App\Http\Controllers\Api\Content\NewEventController;
use App\Http\Controllers\Api\Content\ImageSliderController;
use App\Http\Controllers\Api\Content\AnnouncementController;
use App\Http\Controllers\Api\Content\RectorMessageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    // image slider
    Route::get('/image-sliders', [ImageSliderController::class, 'index']);

    // department
    Route::get('/departments', [DepartmentController::class, 'index']);

    // announcements
    Route::get('/announcements', [AnnouncementController::class, 'index']);
    Route::get('announcements/{announcement}', [AnnouncementController::class, 'show']);

    // new events
    Route::get('/news-events', [NewEventController::class, 'index']);
    Route::get('/news-events/{newEvent}', [NewEventController::class, 'show']);

    // thesis
    Route::get('/thesis/{department_slug}', [ThesisController::class, 'index']);
    Route::get('/thesis/{thesis}', [ThesisController::class, 'show']);

    // rector message
    Route::get('/rector-messages', [RectorMessageController::class, 'index']);

    // activity
    Route::get('/activities', [ActivityController::class, 'index']);
    Route::get('/activities/{activity}', [ActivityController::class, 'show']);
});
