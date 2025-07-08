<?php

namespace App\Http\Controllers\Api\Content;

use App\Models\ImageSlider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Content\ImageSliderResource;

class ImageSliderController extends Controller
{
    public function index() {
        $sliders = ImageSliderResource::collection(ImageSlider::orderBy('image_order_no', 'asc')->get());
        return response()->json($sliders);
    }
}
