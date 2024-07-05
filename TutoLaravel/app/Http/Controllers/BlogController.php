<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogFilterRequest;
use App\Models\Post;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index(BlogFilterRequest $request):View{
       
        $posts = Post::paginate(1);

        return view('blog.index',[
            'posts' => $posts
        ]);
    }

    public function show(string $slug , Post $post) : RedirectResponse | View{
        $post = Post::findOrFail($post);

        if ($post->slug !== $slug) {
            return redirect()->route('blog.show', ['slug' => $post->slug, 'id' => $post->id]);
        }

       
        return view('blog.show',[
            'post' => $post
        ]);
    }
}
