<?php

namespace App\Http\Resources\Content;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'date' => $this->date ? Carbon::parse($this->date)->format('d-M-y') : null,
            'content' => $this->content,
            'image' => $this->image ? asset('storage' . $this->image) : asset('storage/images/default.jpg'),
            'images' => $this->images ? ActivityImageResource::collection($this->images) : null
        ];
    }
}
