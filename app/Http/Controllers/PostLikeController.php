<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostLikeController extends Controller
{
    //
    public function store($id)
    {
        $user = Auth::user();
        $post = Post::findOrFail($id);

        if ($post->likedBy()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'Anda sudah menyukai postingan ini.'], 200);
        }

        $post->likedBy()->attach($user->id);
        $post->increment('likes_count');

        return response()->json(['message' => 'Postingan berhasil di-like.'], 200);
    }
    public function destroy($id)
    {
        $user = Auth::user();
        $post = Post::findOrFail($id);

        if (!$post->likedBy()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'Anda belum menyukai postingan ini.'], 200);
        }

        $post->likedBy()->detach($user->id);
        $post->decrement('likes_count');

        return response()->json(['message' => 'Like berhasil dibatalkan.'], 200);
    }
}
