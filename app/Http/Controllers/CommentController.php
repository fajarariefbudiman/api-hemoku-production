<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    //
    public function index($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Postingan tidak ditemukan.'], 404);
        }

        $comments = Comment::with('user')
            ->where('post_id', $id)
            ->latest()
            ->get();

        return response()->json(CommentResource::collection($comments), 200);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $post = Post::find($id);
        if (!$post) {
            return response()->json(['message' => 'Postingan tidak ditemukan.'], 404);
        }

        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);
        $post->increment('comments_count');

        return response()->json(new CommentResource($comment->load('user')), 201);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $comment = Comment::with('post')->find($id);

        if (!$comment) {
            return response()->json(['message' => 'Komentar tidak ditemukan.'], 404);
        }

        if ($comment->user_id !== $user->id && $comment->post->user_id !== $user->id) {
            return response()->json(['message' => 'Anda tidak memiliki izin untuk menghapus komentar ini.'], 401);
        }

        $comment->post->decrement('comments_count');
        $comment->delete();

        return response()->json(null, 204);
    }
}
