<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with([
            'user',
            'comments.user'
        ])
            ->withCount('likedBy')
            ->latest()
            ->get();

        return response()->json(PostResource::collection($posts), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Terjadi kesalahan pada data yang Anda kirimkan. Mohon periksa kembali.',
                'errors'  => $validator->errors()
            ], 400);
        }

        $post = Post::create([
            'user_id' => Auth::id(),
            'content' => $request->content
        ]);

        return response()->json(new PostResource($post->load('user')), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'message' => 'Postingan tidak ditemukan.'
            ], 404);
        }

        if ($post->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Anda tidak memiliki izin untuk menghapus postingan ini.'
            ], 403);
        }

        $post->delete();

        return response()->noContent();
    }
}
