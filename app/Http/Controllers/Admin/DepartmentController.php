<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class DepartmentController extends Controller
{
    public function index() {
        return view('admin.department.index');
    }

    public function departmentsList() {
        $data = Department::latest();

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->addIndexColumn()
            ->editColumn('logo', function($each) {
                return '<img src="' . asset('storage/' . $each->logo ) . '" width="100" />';
            })
            ->addColumn('action', function ($each) {
                $show_icon = '';
                $edit_icon = '';
                $del_icon = '';

                // if (auth()->user()->can('user_show')) {
                //     $show_icon = '<a href="' . route('admin.users.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-4"></i></a>';
                // }

                // if (auth()->user()->can('brand_edit')) {
                    $edit_icon = '<a href="' . route('admin.departments.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
                // }

                // if (auth()->user()->can('brand_delete')) {
                    $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';
                // }

                return '<div class="action-icon">' . $show_icon . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['logo', 'action'])
            ->make(true);
    }

    public function create() {
        return view('admin.department.create');
    }

    public function store(Request $request)
    {

        DB::beginTransaction();

        try {
            if ($request->file('logo')) {
                $fileName = uniqid() . $request->file('logo')->getClientOriginalName();
                $request->file('logo')->storeAs('public/images/departments', $fileName);
            }

            $department = new Department();
            $department->name = $request->name;
            $department->logo = $fileName ? '/images/departments/' . $fileName : null;
            $department->created_by = auth()->user()->id;
            $department->save();

            DB::commit();
            session()->flash('success', 'Successfully Created !');
            return 'success';

        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }

    }

    public function edit(Department $department) {

        return view('admin.department.edit', compact('department'));
    }

    public function updateDepartment(Request $request, Department $department)
    {
        DB::beginTransaction();

        try {
            $fileName = null;
            if ($request->file('logo')) {
                //delete old file
                \File::delete(public_path('/storage' . $department->logo));

                $fileName = uniqid() . $request->file('logo')->getClientOriginalName();
                $request->file('logo')->storeAs('public/images/departments', $fileName);

            }

            $department->name = $request->name;
            $department->logo = $fileName ? '/images/departments/' . $fileName : $department->logo;
            $department->updated_by = auth()->user()->id;
            $department->update();

            DB::commit();
            session()->flash('success', 'Successfully Updated !');
            return 'success';

        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function destroy(Department $department) {
        if($department->logo) {
            \File::delete(public_path('/storage' . $department->logo));
        }
        $department->delete();
        return 'success';
    }
}
