<?php

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/blog')->group(function () {

    Route::get('/', function (Request $request) {
        // $post = new Post();
        // $post->title = "Mon second article";
        // $post->slug = 'mon-second-article';
        // $post->content = "Ceci est mon second article";
        // // $post->save();

        $posts = Post::paginate(25);
        
        return $posts;

        // return [
        //     // "name" => $request->path(),
        //     // "name" => $request->url(),
        //     // "name" => $request->all(),
        //     // "name" => $request->input('name', 'Berenis'),
        //     // "article" => "Article 1"
        //     "link" => \route('blog.show', ['slug' => "article", "id" => 13])
        // ];
    })->name('index');
    
    
    Route::get('/{slug}-{id}', function (string $slug, string $id, Request $request) {
       
        $post = Post::findOrFail($id);

        if ($post->slug !== $slug) {
            return redirect()->route('show', ['slug' => $post->slug, 'id' => $post->id]);
        }

        return $post;
       
        // return [
        //     "slug" => $slug,
        //     "id" => $id,
        //     "name" => $request->input('name')
        // ];
    })->where(
        [
            "id" => '[0-9]+',
            "slug" => '[a-z0-9\-]+'
        ]
    )->name('show');
});
