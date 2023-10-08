<?php
namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        return Comments::all();
    }

    public function getReviewsForPost($postId)
    {
        return Comments::where('post_id', $postId)->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'author' => 'required',
            'desc' => 'required',
            'post_id' => 'required',
            'time' => 'required',
        ]);

        return Comments::create($request->all());
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function update(Request $request, $id)
    {
        $review = Comments::findOrFail($id);
        $review->update($request->all());

        return $review;
    }

    public function destroy($id)
    {
        return Comments::destroy($id);
    }
}
