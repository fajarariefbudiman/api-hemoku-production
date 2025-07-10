<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'user_id'        => $this->user_id,
            'content'        => $this->content,
            'likes_count'    => $this->likes_count ?? 0,
            'comments_count' => $this->comments_count ?? 0,
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
            'author'         => [
                'id'       => $this->user->id,
                'fullname' => $this->user->fullname ?? $this->user->name,
                'email'    => $this->user->email,
            ],
            'comments'       => CommentResource::collection($this->whenLoaded('comments')),
        ];
    }
}
