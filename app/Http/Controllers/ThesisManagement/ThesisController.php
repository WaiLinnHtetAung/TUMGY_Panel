<?php

namespace App\Http\Controllers\ThesisManagement;

use App\Models\Thesis;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class ThesisController extends Controller
{
    public function thesisByDepartment($department) {

        $department = Department::where('slug', $department)->first();
        $department_slug = $department->slug;

        $thesis = Thesis::where('department_id', $department->id)->orderBy('created_at', 'desc')->get();

        return view('thesis_management.thesis.index', compact('thesis', 'department_slug'));
    }

    public function thesisList($department)
    {
        $department = Department::where('slug', $department)->first();

        $data = Thesis::with('department')->where('department_id', $department->id)->latest();

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->addIndexColumn()

            ->editColumn('roll_no', function ($each) {
                return '<span class="text-nowrap">' . $each->roll_no . '</span>';
            })

            ->addColumn('department_id', function ($each) {
                return $each->department->name;
            })

            ->filterColumn('department_id', function ($query, $keyword) {
                $query->whereHas('department', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                });
            })

            ->editColumn('file', function($each) {
                if ($each->file) {
                    $url = asset('storage/' . $each->file);

                    return '<a href="' . $url . '" download target="_blank" class="text-decoration-underline text-nowrap">
                                <img src="' . asset('assets/images/zip_icon.png') . '" width="40" class="me-2" />
                                Download
                            </a>';

                } else {
                    return '<span class="text-danger" style="font-size: 14px;">No File</span>';
                }
            })

            ->addColumn('action', function ($each) {
                $show_icon = '';
                $edit_icon = '';
                $del_icon = '';

                // if (auth()->user()->can('user_show')) {
                //     $show_icon = '<a href="' . route('admin.users.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-4"></i></a>';
                // }

                // if (auth()->user()->can('brand_edit')) {
                    $edit_icon = '<a href="' . route('thesis-management.thesis.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
                // }

                // if (auth()->user()->can('brand_delete')) {
                    $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';
                // }

                return '<div class="action-icon text-nowrap">' . $show_icon . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['roll_no', 'file', 'action'])
            ->make(true);

    }

    public function create(Request $request) {

        $department_slug = $request->department;
        $departments = Department::select('id', 'slug', 'name')->get();
        $years = [2018, 2019, 2020, 2021, 2022, 2023, 2024, 2025, 2026, 2027, 2028, 2029, 2030];
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        return view('thesis_management.thesis.create', compact('department_slug', 'departments', 'years', 'months'));
    }

    public function store(Request $request) {
        DB::beginTransaction();

        try {
            $fileName = null;
            if ($request->file('file')) {
                $fileName = uniqid() . $request->file('file')->getClientOriginalName();
                $request->file('file')->storeAs('public/thesis_files', $fileName);
            }

            $thesis = new Thesis();
            $thesis->title = $request->title;
            $thesis->department_id = $request->department_id;
            $thesis->author = $request->author;
            $thesis->roll_no = $request->roll_no;
            $thesis->submission_year = $request->submission_year;
            $thesis->submission_month = $request->submission_month;
            $thesis->file = $fileName ? '/thesis_files/' . $fileName : null;
            $thesis->created_by = auth()->user()->id;
            $thesis->save();

            DB::commit();
            session()->flash('success', 'Successfully Created !');
            return 'success';

        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function edit(Thesis $thesi) {
        $departments = Department::select('id', 'slug', 'name')->get();
        $department_slug = $thesi->department->slug;
        $years = [2018, 2019, 2020, 2021, 2022, 2023, 2024, 2025, 2026, 2027, 2028, 2029, 2030];
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        return view('thesis_management.thesis.edit', compact('thesi', 'departments', 'department_slug', 'years', 'months'));
    }

    public function updateThesis(Request $request, Thesis $thesi) {
        DB::beginTransaction();

        try {
            $fileName = null;
            if ($request->file('file')) {
                //delete old file
                \File::delete(public_path('/storage' . $thesi->file));

                $fileName = uniqid() . $request->file('file')->getClientOriginalName();
                $request->file('file')->storeAs('public/thesis_files', $fileName);
            }

            $thesi->title = $request->title;
            $thesi->department_id = $request->department_id;
            $thesi->author = $request->author;
            $thesi->roll_no = $request->roll_no;
            $thesi->submission_year = $request->submission_year;
            $thesi->submission_month = $request->submission_month;
            $thesi->file = $fileName ? '/thesis_files/' . $fileName : $thesi->file;
            $thesi->updated_by = auth()->user()->id;
            $thesi->update();

            DB::commit();
            session()->flash('success', 'Successfully Updated !');
            return 'success';

        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function destroy(Thesis $thesi) {
        if($thesi->file) {
            \File::delete(public_path('/storage' . $thesi->file));
        }
        $thesi->delete();
        session()->flash('success', 'Successfully Deleted !');
        return 'success';
    }
}
