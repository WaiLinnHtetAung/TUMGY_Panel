<?php

use App\Http\Controllers\ContentManagement\DropzoneController;
use App\Http\Controllers\ContentManagement\NewEventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\ThesisManagement\ThesisController;
use App\Http\Controllers\ContentManagement\ImageSliderController;
use App\Http\Controllers\ContentManagement\AnnouncementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */
Route::get('/', function () {return redirect()->route('admin.home');});

Route::group(['middleware' => ['auth', 'prevent-back-history'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', [ProfileController::class, 'dashboard'])->name('home');

    //permission
    Route::get('/permission-datatable', [PermissionController::class, 'dataTable']);
    Route::resource('permissions', PermissionController::class);

    //roles
    Route::get('/roles-datatable', [RolesController::class, 'dataTable']);
    Route::resource('roles', RolesController::class);

    //users
    Route::get('/users-datatable', [UserController::class, 'dataTable']);
    Route::resource('users', UserController::class);

    // departments
    Route::get('/departments-list', [DepartmentController::class, 'departmentsList']);
    Route::post('/update-department/{department}', [DepartmentController::class, 'updateDepartment']);
    Route::resource('departments', DepartmentController::class);

});

// thesis
Route::group(['middleware' => ['auth', 'prevent-back-history']], function () {

    // thesis
    Route::group(['middleware' => ['auth', 'prevent-back-history'], 'prefix' => 'thesis-management', 'as' => 'thesis-management.'], function () {
        //thesis
        Route::get('{department}/thesis', [ThesisController::class, 'thesisByDepartment'])->name('thesis_by_department');
        Route::get('/thesis-list/{department}', [ThesisController::class, 'thesisList']);
        Route::post('/update-thesis/{thesi}', [ThesisController::class, 'updateThesis']);
        Route::resource('thesis', ThesisController::class);
    });

    //content management
    Route::group(['middleware' => ['auth', 'prevent-back-history'], 'prefix' => 'content-management', 'as' => 'content-management.'], function () {
        // slider
        Route::get('image-slider-list', [ImageSliderController::class, 'sliderLists']);
        Route::post('update-image-slider/{imageSlider}', [ImageSliderController::class, 'updateSlider']);
        Route::resource('image-sliders', ImageSliderController::class);

        // announcement
        Route::get('announcement-list', [AnnouncementController::class, 'announcementLists']);
        Route::post('update-announcement/{announcement}', [AnnouncementController::class, 'updateAnnouncement']);
        Route::resource('announcements', AnnouncementController::class);

        // news events
        Route::get('news-events-list', [NewEventController::class, 'newsEventsLists']);
        Route::post('update-news-events/{newsEvent}', [NewEventController::class, 'updateNewsEvents']);
        Route::resource('news-events', NewEventController::class);

        // dropzone
        Route::post('/storeMedia', [DropzoneController::class, 'storeMedia'])->name('storeMedia');
        Route::post('/deleteMedia', [DropzoneController::class, 'deleteMedia'])->name('deleteMedia');
    });
});

require __DIR__ . '/auth.php';
