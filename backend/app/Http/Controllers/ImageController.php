<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate(['image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048']);

        $path = $request->file('image')->store('public/images');

        $image = new Image;
        $image->path = $path;
        $image->save();

        return response()->json(['url' => asset(Storage::url($path))]);
    }

}