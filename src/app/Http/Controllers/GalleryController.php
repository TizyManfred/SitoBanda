<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GalleryAlbum;
use App\Models\GalleryItem;

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
            // Get all public gallery albums with pagination and first image as cover
            $albums = GalleryAlbum::where('is_published', 1)
                ->withCount('items')
                ->with(['items' => function($query) {
                    $query->orderBy('created_at', 'asc')->take(1);
                }])
                ->orderBy('created_at', 'desc')
                ->paginate(12);
                
            // Get distinct years for filtering
            $years = GalleryAlbum::where('is_published', 1)
                ->selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year')
                ->toArray();
                
        } catch (\Exception $e) {
            \Log::error("Error fetching gallery albums: " . $e->getMessage());
            $albums = collect([]);
            $years = [];
        }
        
        return view('gallery.index', compact('albums', 'years'));
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
            // Find album by slug in any language
            $album = GalleryAlbum::where('is_published', 1)
                ->where(function($query) use ($slug) {
                    $query->where('slug->it', $slug)
                          ->orWhere('slug->en', $slug)
                          ->orWhere('slug->de', $slug);
                })
                ->firstOrFail();    
                
            // Get all images in this album
            $images = GalleryItem::where('album_id', $album->id)
                ->orderBy('sort_order', 'asc')
                ->get();
                
            // Get related event if exists
            $event = $album->event;
            
            // Get other albums (for navigation)
            $otherAlbums = GalleryAlbum::where('id', '!=', $album->id)
                ->where('is_published', 1)
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get();

            $album->view_count = $album->view_count + 1;
            $album->save();
                
        } catch (\Exception $e) {
            \Log::error("Error fetching gallery album: " . $e->getMessage());
            abort(404);
        }
        
        return view('gallery.show', compact('album', 'images', 'event', 'otherAlbums'));
    }
}
