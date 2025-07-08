<?php

namespace App\Http\Resources\Edu;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThesisResource extends JsonResource
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
            'slug' => $this->slug,
            'department_id' => $this->department_id,
            'department' => $this->department->name,
            'author' => $this->author,
            'roll_no' => $this->roll_no,
            'submission_year' => $this->submission_year,
            'submission_month' => $this->submission_month,
            'file' => $this->file ? asset('storage' . $this->file) : null
        ];
    }
}
