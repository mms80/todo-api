<?php

namespace mms80\TodoApi\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use mms80\TodoApi\Task;
use mms80\TodoApi\Http\Resources\LabelAPIResource;

class TaskAPIResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            "status" => Task::toString($this->status),
            "labels" => LabelAPIResource::collection($this->labels),
        ];
    }
}
