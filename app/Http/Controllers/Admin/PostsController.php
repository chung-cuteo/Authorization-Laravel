<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Post;

class PostsController extends Controller
{
    public function index()
    {
        $listPosts = Post::orderBy('created_at', 'desc')->get();

        return view('admin.posts.lists', compact('listPosts'));
    }

    public function add()
    {
        return view('admin.posts.add');
    }

    public function postAdd(Request $request)
    {
        $request->validate(
            [
                'title' => 'required',
                'content' => 'required',
            ],
            [
                'title.required' => 'Title not empty',
                'content.required' => 'Content not empty',
            ]
        );

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = Auth::user()->id;
        $post->save();

        return redirect()->route('admin.posts.index')->with('msg', 'Post is added');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('admin.posts.edit', compact('post'));
    }

    public function postEdit(Post $post, Request $request)
    {
        $request->validate(
            [
                'title' => 'required',
                'content' => 'required',
            ],
            [
                'title.required' => 'Title not empty',
                'content.required' => 'Content not empty',
            ]
        );
        $post->title = $request->title;
        $post->content = $request->content;
        $post->save();

        return back()->with('msg', 'Post is updated');
    }

    public function delete(Post $post)
    {
        $this->authorize('delete', $post);

        Post::destroy($post->id);
        return redirect()->route('admin.posts.index')->with('msg', 'Post is deleted');
    }
}
