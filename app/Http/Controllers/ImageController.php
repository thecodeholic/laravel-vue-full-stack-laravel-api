<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Image::latest()
            ->get()
            ->map(function ($image) {
                return [
                    'id' => $image->id,
                    'url' => url(Storage::url($image->path)),
                    'label' => $image->label,
                ];
            });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'file', 'image', 'mimes:jpeg,png,jpg'],
            'label' => ['nullable', 'string', 'max:255'],
        ]);

        $path = $request->file('image')->store('images', 'public');

        $image = Image::create([
            'path' => $path,
            'label' => $request->label
        ]);

        return response($image, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        $image->delete();

        return response(null, 204);
    }
}
