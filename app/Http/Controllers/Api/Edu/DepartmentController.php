<?php

namespace App\Http\Controllers\Api\Edu;

use App\Http\Controllers\Controller;
use App\Http\Resources\Edu\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index() {
        $departments = DepartmentResource::collection(Department::select('id', 'slug', 'name', 'logo')->get());
        return response()->json($departments);
    }
}
