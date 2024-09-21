<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogPosts = BlogPost::all();
        return view('blog.index', ['blogPosts'=>$blogPosts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::check()) {return redirect('/blog'); }
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {return redirect('/blog'); }
        $save_data = [
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => Auth::id()
        ];

        $created_post = BlogPost::create($save_data);
        return redirect("/blog/{$created_post->id}");
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogPost $blogPost)
    {
        return view('blog.show', ['blogPost'=>$blogPost]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogPost $blogPost)
    {
        if (!Auth::check()) {return redirect('/blog'); }
        if (Auth::id() != $blogPost->user_id) { return redirect("/blog/{$blogPost->id}"); }

        return view('blog.edit', ['blogPost'=>$blogPost]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogPost $blogPost)
    {
        if (!Auth::check()) {return redirect('/blog'); }
        if (Auth::id() != $blogPost->user_id) { return redirect("/blog/{$blogPost->id}"); }

        $save_data = [
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => Auth::id()
        ];
        $blogPost->update($save_data);
        return redirect("/blog/{$blogPost->id}");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogPost $blogPost)
    {
        if (!Auth::check()) {return redirect('/blog'); }
        if (Auth::id() != $blogPost->user_id) { return redirect("/blog/{$blogPost->id}"); }

        $blogPost->delete();
        return redirect('/blog');
    }
}
