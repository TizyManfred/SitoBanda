<?php

namespace App\Http\Controllers;

use App\Models\GalleryAlbum;
use App\Models\GalleryItem;
use Illuminate\Http\Response;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class GalleryController extends Controller
{
    /**
     * Display a listing of gallery albums.
     *
     * @return Response
     */
    public function index()
    {
        try {
            // Get all public gallery albums with pagination and first image as cover
            $albums = GalleryAlbum::where('is_published', 1)
                ->withCount('items')
                ->with(['items' => function ($query) {
                    // Load up to 4 random items per album for carousel preview
                    $query->inRandomOrder()->take(4);
                }])
                ->orderBy('start_date', 'desc')
                ->paginate(12);

            // Get distinct years for filtering
            $years = GalleryAlbum::where('is_published', 1)
                ->selectRaw('YEAR(start_date) as year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year')
                ->toArray();

        } catch (\Exception $e) {
            \Log::error('Error fetching gallery albums: '.$e->getMessage());
            $albums = collect([]);
            $years = [];
        }

        return view('gallery.index', compact('albums', 'years'));
    }

    /**
     * Display the specified gallery album.
     *
     * @param  string  $slug
     * @return Response
     */
    public function show($slug)
    {
        try {
            // Find album by slug in any language
            $album = GalleryAlbum::where('is_published', 1)
                ->where(function ($query) use ($slug) {
                    foreach (array_keys(LaravelLocalization::getSupportedLocales()) as $index => $locale) {
                        $method = $index === 0 ? 'where' : 'orWhere';
                        $query->{$method}("slug->{$locale}", $slug);
                    }
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
            \Log::error('Error fetching gallery album: '.$e->getMessage());
            abort(404);
        }

        return view('gallery.show', compact('album', 'images', 'event', 'otherAlbums'));
    }
}
