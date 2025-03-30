<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct()
    {
        // 리소스 컨트롤러에서 정책으로 권한 확인
        $this->authorizeResource(Blog::class, 'blog');
    }

    /**
     * 블로그 리스트
     */
    public function index()
    {
        return view('blogs.index', [
            //'blogs' => Blog::all()
            //'blogs' => Blog::with('user')->get()
            'blogs' => Blog::with('user')->paginate(2)
        ]);
    }

    /**
     * 블로그 생성 폼
     */
    public function create()
    {
        return view('blogs.create');
    }

    /**
     * 블로그 생성
     */
    public function store(StoreBlogRequest $request)
    {
        $user = $request->user();

        $user->blogs()->create($request->validated());

        // return to_route('dashboard.blogs');
        return to_route('blogs.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Blog $blog)
    {
        $user = $request->user();

        return view('blogs.show', [
            'blog' => $blog,
            'owned' => $user->blogs()->find($blog->id), // 블로그 소유 여부
            'subscribed' => $blog->subscribers()->find($user->id) // 블로그 구독 여부
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('blogs.edit', [
            'blog' => $blog
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBlogRequest $request, Blog $blog)
    {
        $blog->update($request->validated());

        // return to_route('dashboard.blogs');
        return to_route('blogs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        // return to_route('dashboard.blogs');
        return to_route('blogs.index');
    }
}
