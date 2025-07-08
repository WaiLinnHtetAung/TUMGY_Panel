<?php

namespace App\Http\Controllers\Api\Thesis;

use App\Models\Thesis;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Edu\ThesisResource;

class ThesisController extends Controller
{
    public function index($department_slug) {
        $department = Department::where('slug', $department_slug)->first();
        $years = Thesis::where('department_id', $department->id)->select('submission_year')->distinct()->orderByDesc('submission_year')->pluck('submission_year');
        $thesis = ThesisResource::collection(Thesis::where('department_id', $department->id)->latest()->get());

        return response()->json(compact('thesis', 'years'));
    }
}
