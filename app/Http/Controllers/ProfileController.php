<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Announcement;
use App\Models\Department;
use App\Models\NewEvent;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function dashboard()
    {
        $department_count = Department::count();
        $news_count = NewEvent::count();
        $announcement_count = Announcement::count();
        $activity_count = Activity::count();

        return view('dashboard', compact('department_count', 'news_count', 'announcement_count', 'activity_count'));
    }

}
