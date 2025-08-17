<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Blog;
use App\Models\Post;

class PostController extends Controller
{
    public function __construct()
    {
        // 리소스 컨트롤러에서 정책으로 권한 확인
        $this->authorizeResource(Post::class, 'post', [
            'except' => ['create', 'store']
        ]);

        // 미들웨어로 정책 권한 확인
        $this->middleware('can:create,App\Models\Post,blog')
            ->only(['create', 'store']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Blog $blog)
    {
        return view('blogs.posts.index', [
            'posts' => $blog->posts()->latest()->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Blog $blog)
    {
        return view('blogs.posts.create', [
            'blog' => $blog
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request, Blog $blog)
    {
        $post = $blog->posts()->create($request->only(['title', 'content']));

        return to_route('posts.show', $post);
    }

    /**
     * 글 읽기
     */
    public function show(Post $post)
    {
        return view('blogs.posts.show', [
            'post' => $post->loadCount('comments'),
            'comments' => $post->comments() // show.blade.php 에서 $post->comments를 $comments로 변경해야 함.
                ->whereNull('parent_id')
                ->with(['user', 'replies.user'])
                ->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('blogs.posts.edit', [
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update(
            $request->only(['title', 'content'])
        );
        return to_route('posts.show', $post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return to_route('blogs.posts.index', $post->blog);
    }
}
