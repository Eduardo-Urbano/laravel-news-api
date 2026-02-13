<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'tag' => $this->tag,
            'summary' => $this->summary,
            'content' => $this->content,
            'created_at' => $this->created_at,

            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
            ],

            'author' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
        ];
    }
}