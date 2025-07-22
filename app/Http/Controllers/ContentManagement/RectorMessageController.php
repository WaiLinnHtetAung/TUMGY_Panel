<?php

namespace App\Http\Controllers\ContentManagement;

use Illuminate\Http\Request;
use App\Models\RectorMessage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class RectorMessageController extends Controller
{
    public function index() {
        $count = RectorMessage::count();
        return view('content_management.rector_message.index', compact('count'));
    }

    public function rectorMessageLists()
    {
        $data = RectorMessage::orderBy('created_at', 'asc');

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->addIndexColumn()
            ->editColumn('image', function($each) {
                return '<img src="' . asset('storage/' . $each->image ) . '" width="100" />';
            })

            ->editColumn('message', function($each) {
                return \Str::limit(strip_tags($each->message), 100);
            })
            ->addColumn('action', function ($each) {
                $show_icon = '';
                $edit_icon = '';
                $del_icon = '';

                if (auth()->user()->can('rector_message_view')) {
                    $show_icon = '<a href="' . route('content-management.rector-messages.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-4"></i></a>';
                }

                if (auth()->user()->can('rector_message_edit')) {
                    $edit_icon = '<a href="' . route('content-management.rector-messages.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
                }

                if (auth()->user()->can('rector_message_delete')) {
                    $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';
                }

                return '<div class="action-icon text-nowrap">' . $show_icon . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['image', 'action'])
            ->make(true);

    }

    public function create() {
        return view('content_management.rector_message.create');
    }

    public function store(Request $request) {
        DB::beginTransaction();

        try {
            if ($request->file('image')) {
                $fileName = uniqid() . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/images/', $fileName);
            }

            $rectoreMessage = new RectorMessage();
            $rectoreMessage->name = $request->name;
            $rectoreMessage->image = $fileName ? '/images/' . $fileName : null;
            $rectoreMessage->message = $request->message;
            $rectoreMessage->created_by = auth()->user()->id;
            $rectoreMessage->save();

            DB::commit();
            session()->flash('success', 'Successfully Created !');
            return 'success';

        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function show(RectorMessage $rector_message) {
        return view('content_management.rector_message.show', compact('rector_message'));
    }

    public function edit(RectorMessage $rector_message) {
        return view('content_management.rector_message.edit', compact('rector_message'));
    }

    public function updateRectorMessage(Request $request, RectorMessage $rectorMessage) {
        DB::beginTransaction();

        try {
            $fileName = null;
            if ($request->file('image')) {
                //delete old file
                \File::delete(public_path('/storage' . $rectorMessage->image));

                $fileName = uniqid() . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/images/', $fileName);

            }

            $rectorMessage->name = $request->name;
            $rectorMessage->image = $fileName ? '/images/' . $fileName : $rectorMessage->image;
            $rectorMessage->message = $request->message;
            $rectorMessage->updated_by = auth()->user()->id;
            $rectorMessage->update();

            DB::commit();
            session()->flash('success', 'Successfully Updated !');
            return 'success';

        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function destroy(RectorMessage $rector_message) {
        DB::beginTransaction();
        try {
            if($rector_message->image){
                \File::delete(public_path('/storage' . $rector_message->image));
            }
            $rector_message->delete();
            DB::commit();
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }
}
