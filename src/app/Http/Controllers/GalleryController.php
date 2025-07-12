<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GalleryAlbum;
use App\Models\GalleryImage;

class GalleryController extends Controller
{
    /**
     * Display a listing of gallery albums.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            // Get all public gallery albums
            $albums = GalleryAlbum::where('is_public', 1)
                ->orderBy('created_at', 'desc')
                ->get();
                
        } catch (\Exception $e) {
            \Log::error("Error fetching gallery albums: " . $e->getMessage());
            $albums = collect([]);
        }
        
        return view('gallery.index', compact('albums'));
    }

    /**
     * Display the specified gallery album.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        try {
            // Find album by slug
            $album = GalleryAlbum::where('slug', $slug)
                ->where('is_public', 1)
                ->firstOrFail();
                
            // Get all images in this album
            $images = GalleryImage::where('album_id', $album->id)
                ->orderBy('display_order', 'asc')
                ->get();
                
            // Get related event if exists
            $event = $album->event;
            
            // Get other albums (for navigation)
            $otherAlbums = GalleryAlbum::where('id', '!=', $album->id)
                ->where('is_public', 1)
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get();
                
        } catch (\Exception $e) {
            \Log::error("Error fetching gallery album: " . $e->getMessage());
            abort(404);
        }
        
        return view('gallery.show', compact('album', 'images', 'event', 'otherAlbums'));
    }
}
