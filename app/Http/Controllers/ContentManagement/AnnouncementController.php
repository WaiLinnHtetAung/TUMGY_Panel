<?php

namespace App\Http\Controllers\ContentManagement;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class AnnouncementController extends Controller
{
    public function index() {
        return view('content_management.announcement.index');
    }

    public function announcementLists()
    {
        $data = Announcement::orderBy('created_at', 'asc');

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->addIndexColumn()
            ->editColumn('image', function($each) {
                return '<img src="' . asset('storage/' . $each->image ) . '" width="100" />';
            })
            ->editColumn('document', function($each) {
                if ($each->document) {
                    $url = asset('storage/' . $each->document);

                    return '<a href="' . $url . '" target="_blank" class="text-decoration-underline text-nowrap">
                                <img src="' . asset('assets/images/pdf_icon.png') . '" width="40" class="me-2" />
                                View
                            </a>';

                } else {
                    return '<span class="text-danger" style="font-size: 14px;">No File</span>';
                }
            })
            ->editColumn('content', function($each) {
                return \Str::limit(strip_tags($each->content), 100);
            })
            ->addColumn('action', function ($each) {
                $show_icon = '';
                $edit_icon = '';
                $del_icon = '';

                if (auth()->user()->can('announcement_view')) {
                    $show_icon = '<a href="' . route('content-management.announcements.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-4"></i></a>';
                }

                if (auth()->user()->can('announcement_edit')) {
                    $edit_icon = '<a href="' . route('content-management.announcements.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
                }

                if (auth()->user()->can('announcement_delete')) {
                    $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';
                }

                return '<div class="action-icon text-nowrap">' . $show_icon . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['image', 'document', 'action'])
            ->make(true);

    }

    public function create() {
        return view('content_management.announcement.create');
    }

    public function store(Request $request) {
        DB::beginTransaction();

        try {
            $imageName = null;
            $documentName = null;
            if ($request->file('image')) {
                $imageName = uniqid() . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/images/announcement', $imageName);
            }

            if ($request->file('document')) {
                $documentName = uniqid() . $request->file('document')->getClientOriginalName();
                $request->file('document')->storeAs('public/images/announcement', $documentName);
            }

            $announcement = new Announcement();
            $announcement->title = $request->title;
            $announcement->date = $request->date;
            $announcement->image = $imageName ? '/images/announcement/' . $imageName : null;
            $announcement->document = $documentName ? '/images/announcement/' . $documentName : null;
            $announcement->content = $request->content;
            $announcement->save();

            DB::commit();
            session()->flash('success', 'Successfully Created !');
            return 'success';

        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function show(Announcement $announcement) {
        return view('content_management.announcement.show', compact('announcement'));
    }

    public function edit(Announcement $announcement) {
        return view('content_management.announcement.edit', compact('announcement'));
    }

    public function updateAnnouncement (Request $request, Announcement $announcement) {
        DB::beginTransaction();

        try {
            $imageName = null;
            $documentName = null;

            if ($request->file('image')) {
                //delete old file
                \File::delete(public_path('/storage' . $announcement->image));

                $imageName = uniqid() . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/images/announcement', $imageName);

            }

            if ($request->file('document')) {
                //delete old file
                \File::delete(public_path('/storage' . $announcement->document));

                $documentName = uniqid() . $request->file('document')->getClientOriginalName();
                $request->file('document')->storeAs('public/images/announcement', $documentName);
            }

            $announcement->title = $request->title;
            $announcement->date = $request->date;
            $announcement->image = $imageName ? '/images/announcement/' . $imageName : $announcement->image;
            $announcement->document = $documentName ? '/images/announcement/' . $documentName : $announcement->document;
            $announcement->content = $request->content;
            $announcement->update();

            DB::commit();
            session()->flash('success', 'Successfully Updated !');
            return 'success';

        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function destroy(Announcement $announcement) {
        DB::beginTransaction();
        try {
            if($announcement->image){
                \File::delete(public_path('/storage' . $announcement->image));
            }
            if($announcement->document){
                \File::delete(public_path('/storage' . $announcement->document));
            }
            $announcement->delete();
            DB::commit();
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }
}
