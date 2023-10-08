<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {

        return Post::with('comments')->get();
    }

    public function show($id)
    {
        return Post::with('comments')->findOrFail($id);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'short_desc' => 'required',
            'desc' => 'required',
            'author' => 'required',
            'user_id' => 'required',
        ]);
        
        return Post::create($validatedData);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->update($request->all());

        return $post;
    }

    public function destroy($id)
    {
        return Post::destroy($id);
    }
}
