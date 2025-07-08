<?php

namespace App\Http\Controllers\ContentManagement;

use App\Models\NewEvent;
use App\Models\NewEventImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use DataTables;

class NewEventController extends Controller
{
    public function index() {
        return view('content_management.news_event.index');
    }

    public function newsEventsLists()
    {
        $data = NewEvent::with('images')->orderBy('created_at', 'asc');

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

                if (auth()->user()->can('news_event_view')) {
                    $show_icon = '<a href="' . route('content-management.news-events.show', $each->id) . '" class="text-warning me-3"><i class="bx bxs-show fs-4"></i></a>';
                }

                if (auth()->user()->can('news_event_edit')) {
                    $edit_icon = '<a href="' . route('content-management.news-events.edit', $each->id) . '" class="text-info me-3"><i class="bx bx-edit fs-4" ></i></a>';
                }

                if (auth()->user()->can('news_event_delete')) {
                    $del_icon = '<a href="" class="text-danger delete-btn" data-id="' . $each->id . '"><i class="bx bxs-trash-alt fs-4" ></i></a>';
                }

                return '<div class="action-icon text-nowrap">' . $show_icon . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['image', 'images', 'action'])
            ->make(true);

    }

    public function create() {
        return view('content_management.news_event.create');
    }

    public function store(Request $request) {
        DB::beginTransaction();


        try {
            $imageName = null;
            if ($request->file('image')) {
                $imageName = uniqid() . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/images/news_event', $imageName);
            }

            $newEvent = new NewEvent();
            $newEvent->title = $request->title;
            $newEvent->date = $request->date;
            $newEvent->type = $request->type;
            $newEvent->image = $imageName ? '/images/news_event/' . $imageName : null;
            $newEvent->content = $request->content;
            $newEvent->save();

            if(!empty($request->images) && is_array($request->images)) {

                // create folder if not exist
                $path = public_path('storage/images/news_event/');

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                foreach ($request->input('images', []) as $image) {

                    $sourcePath = storage_path('tmp/uploads/' . $image);
                    $destinationPath = public_path('storage/images/news_event/' . $image);

                    if (file_exists($sourcePath)) {

                        \File::move($sourcePath, $destinationPath);

                        $newEventImage = new NewEventImage();
                        $newEventImage->image = '/images/news_event/' . $image;
                        $newEventImage->new_event_id = $newEvent->id;
                        $newEventImage->save();
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

    public function show(NewEvent $news_event) {
        return view('content_management.news_event.show', compact('news_event'));
    }

    public function edit(NewEvent $news_event) {

        $news_event_images = array_map(function ($image) {
            return [
                'image_name' => $image['image'],
                'image_path' => asset('storage/' . $image['image']),
            ];
        }, $news_event->images->toArray());


        return view('content_management.news_event.edit', compact('news_event', 'news_event_images'));
    }

    public function updateNewsEvents (Request $request, NewEvent $newsEvent) {
        DB::beginTransaction();

        try {
            $imageName = null;

            if ($request->file('image')) {
                //delete old file
                \File::delete(public_path('/storage' . $newsEvent->image));

                $imageName = uniqid() . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('public/images/news_event', $imageName);

            }

            $newsEvent->title = $request->title;
            $newsEvent->date = $request->date;
            $newsEvent->type = $request->type;
            $newsEvent->image = $imageName ? '/images/news_event/' . $imageName : $newsEvent->image;
            $newsEvent->content = $request->content;
            $newsEvent->update();

            if (count($newsEvent->images) > 0) {
                foreach ($newsEvent->images as $media) {

                    $imagePath = '/'.ltrim($media->image, '/');  // change image format to match input images

                    if (!in_array($imagePath, $request->input('images', []))) {
                        NewEventImage::where('id', $media->id)->delete();
                        \File::delete(public_path('/storage'.$imagePath));
                    }
                }
            }

            $old_images = $newsEvent->images()->pluck('image')->toArray();

            foreach ($request->input('images', []) as $image) {
                if (count($old_images) === 0 || !in_array($image, $old_images)) {

                    $sourcePath = storage_path('tmp/uploads/' . $image);
                    $destinationPath = public_path('storage/images/news_event/' . $image);

                    if (file_exists($sourcePath)) {

                        \File::move($sourcePath, $destinationPath);

                        $newEventImage = new NewEventImage();
                        $newEventImage->image = '/images/news_event/' . $image;
                        $newEventImage->new_event_id = $newsEvent->id;
                        $newEventImage->save();
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

    public function destroy(NewEvent $news_event) {
        DB::beginTransaction();
        try {
            if($news_event->image){
                \File::delete(public_path('/storage' . $news_event->image));
            }
            if($news_event->images){
                foreach ($news_event->images as $image){
                    \File::delete(public_path('/storage' . $image->image));
                }
            }
            $news_event->delete();
            DB::commit();
            return 'success';
        } catch (\Exception $e) {
            DB::rollBack();
            logger($e->getMessage());
            return 'error';
        }
    }
}
