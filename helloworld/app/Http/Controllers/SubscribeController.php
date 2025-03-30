<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscribeRequest;
use App\Http\Requests\UnsubscribeRequest;
use App\Models\Blog;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    /**
     * 구독자 지정
     */
    public function subscribe(SubscribeRequest $request)
    {
        $user = $request->user(); // 현재 로그인한 사용자
        $blog = Blog::find($request->blog_id);

        $user->subscriptions()->attach($blog->id); // 블로그의 구독자로 지정

        return back();
    }

    /**
     * 구독 취소
     */
    public function unsubscribe(UnsubscribeRequest $request)
    {
        $user = $request->user(); // 현재 로그인한 사용자
        $blog = Blog::find($request->blog_id);

        $user->subscriptions()->detach($blog->id); // 블로그 구독 취소

        return back();
    }
}
