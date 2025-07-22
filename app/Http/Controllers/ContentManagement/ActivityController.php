<?php

namespace App\Http\Controllers\ContentManagement;

use App\Models\Activity;
use App\Models\ActivityImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class ActivityController extends Controller
{
    public function index()
    {
        return view('content_management.activity.index');
    }

    public function activityLists()
    {
        $data = Activity::with('images')->orderBy('created_at', 'asc');

        return Datatables::of($data)
            ->editColumn('plus-icon', function ($each) {
                return null;
            })
            ->addIndexColumn()
            ->editColumn('image', function($each) {
                return '<img src="' . asset('storage/' . $each->image ) . '" width="100" />';
            })

            ->editColumn('images', function($each) {
                $image = '';
                $index = 0;

                if($each->images && count($each->images) > 0) {
                    foreach ($each->images as $file) {
                        if ($index < 2) {
                            $filePath = asset('storage/' . $file->image );
                            $style = "width: 40px; height: 40px; display: flex; justify-content:center; align-items:center ;border-radius: 100%; object-fit: cover; border: 1px solid #333;";
                            $style .= $index == 0 ? '' : 'margin-left: -15px;';

                            $image .= "<img src='$filePath' width='35' height='35' style='$style'/>";
                        }
                        $index++;
                    }

                    if ($index > 2) {
                        $index = $index - 2;
                        $image .= "<div style='$style background: #fff;'>+$index</div>";
                    }
                } else {
                    $img = asset('assets/images/default_img.jpg');
                    $image = "<img src='$img' width='35' height='35' style='width: 40px; height: 40px; display: flex; justify-content:center; align-items:center ;border-radius: 100%; object-fit: cover; border: 1px solid #333;'/>";
                }

                return "<div class='d-flex align-items-center'> $image </div>";
            })

            ->editColumn('content', function($each) {
                return \Str::limit(strip_tags($each->content), 100);
            })
            ->addColumn('action', function ($each) {
                $show_icon = '';
                $edit_icon = '';
                $del_icon = '';

                if (auth()->user()->can('activity_view')) {
                    $show_icon = '<a href="' . route('content-management.activities.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-4"></i></a>';
                }

                if (auth()->user()->can('activity_edit')) {
                    $edit_icon = '<a href="' . route('content-management.activities.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
                }

                if (auth()->user()->can('activity_delete')) {
                    $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';
                }

                return '<div class="action-icon text-nowrap">' . $show_icon . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['image', 'images', 'action'])
            ->make(true);

    }

    public function create()
    {
        return view('content_management.activity.create');
    }

    public function store(Request $request) {
        DB::beginTransaction();


        try {
            $imageName = null;
            if ($request->file('image')) {
                $imageName = uniqid() . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/images/activity', $imageName);
            }

            $activity = new Activity();
            $activity->title = $request->title;
            $activity->date = $request->date;
            $activity->image = $imageName ? '/images/activity/' . $imageName : null;
            $activity->content = $request->content;
            $activity->created_by = auth()->user()->id;
            $activity->save();

            if(!empty($request->images) && is_array($request->images)) {

                // create folder if not exist
                $path = public_path('storage/images/activity/');

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                foreach ($request->input('images', []) as $image) {

                    $sourcePath = storage_path('tmp/uploads/' . $image);
                    $destinationPath = public_path('storage/images/activity/' . $image);

                    if (file_exists($sourcePath)) {

                        \File::move($sourcePath, $destinationPath);

                        $activityImage = new ActivityImage();
                        $activityImage->image = '/images/activity/' . $image;
                        $activityImage->activity_id = $activity->id;
                        $activityImage->save();
                    }
                }
            }

            DB::commit();
            session()->flash('success', 'Successfully Created !');
            return 'success';

        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }

    public function show(Activity $activity) {
        return view('content_management.activity.show', compact('activity'));
    }

    public function edit(Activity $activity) {
         $activity_images = array_map(function ($image) {
            return [
                'image_name' => $image['image'],
                'image_path' => asset('storage/' . $image['image']),
            ];
        }, $activity->images->toArray());

        return view('content_management.activity.edit', compact('activity', 'activity_images'));
    }

    public function updateActivity (Request $request, Activity $activity) {
        DB::beginTransaction();

        try {
            $imageName = null;

            if ($request->file('image')) {
                //delete old file
                \File::delete(public_path('/storage' . $activity->image));

                $imageName = uniqid() . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/images/activity', $imageName);

            }

            $activity->title = $request->title;
            $activity->date = $request->date;
            $activity->image = $imageName ? '/images/activity/' . $imageName : $activity->image;
            $activity->content = $request->content;
            $activity->updated_by = auth()->user()->id;
            $activity->update();

            if (count($activity->images) > 0) {
                foreach ($activity->images as $media) {

                    $imagePath = '/'.ltrim($media->image, '/');  // change image format to match input images

                    if (!in_array($imagePath, $request->input('images', []))) {
                        ActivityImage::where('id', $media->id)->delete();
                        \File::delete(public_path('/storage'.$imagePath));
                    }
                }
            }

            $old_images = $activity->images()->pluck('image')->toArray();

            foreach ($request->input('images', []) as $image) {
                if (count($old_images) === 0 || !in_array($image, $old_images)) {

                    $sourcePath = storage_path('tmp/uploads/' . $image);
                    $destinationPath = public_path('storage/images/activity/' . $image);

                    if (file_exists($sourcePath)) {

                        \File::move($sourcePath, $destinationPath);

                        $activityImage = new ActivityImage();
                        $activityImage->image = '/images/activity/' . $image;
                        $activityImage->activity_id = $activity->id;
                        $activityImage->save();
                    }
                }
            }

            DB::commit();
            session()->flash('success', 'Successfully Updated !');
            return 'success';

        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }
    public function destroy(Activity $activity) {
        DB::beginTransaction();
        try {
            if($activity->image){
                \File::delete(public_path('/storage' . $activity->image));
            }
            if($activity->images){
                foreach ($activity->images as $image){
                    \File::delete(public_path('/storage' . $image->image));
                }
            }
            $activity->delete();
            DB::commit();
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }
}
