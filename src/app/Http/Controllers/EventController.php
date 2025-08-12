<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of events.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(\Illuminate\Http\Request $request)
    {
        try {
            // Read filters from query
            $filters = [
                'year' => $request->integer('year'),
                'location' => $request->string('location')->toString(),
                'has_photos' => $request->boolean('has_photos'),
                'featured' => $request->boolean('featured'),
            ];

            // Base query with optional filters
            $applyFilters = function ($query) use ($filters) {
                if (!empty($filters['year'])) {
                    $query->whereYear('start_datetime', $filters['year']);
                }
                if (!empty($filters['location'])) {
                    $query->where('location', $filters['location']);
                }
                if (!empty($filters['has_photos'])) {
                    $query->whereNotNull('gallery_id');
                }
                if (!empty($filters['featured'])) {
                    $query->where('is_featured', true);
                }
                return $query;
            };

            // Upcoming events with filters
            $upcomingQuery = Event::public()->upcoming();
            $upcomingQuery = $applyFilters($upcomingQuery);
            $upcomingEvents = $upcomingQuery
                ->orderBy('start_datetime', 'asc')
                ->get();
            
            // Past events with filters
            $pastQuery = Event::public()->past();
            $pastQuery = $applyFilters($pastQuery);
            $pastEvents = $pastQuery
                ->orderBy('start_datetime', 'desc')
                ->paginate(9)
                ->appends($request->query());

            // Distinct years and locations for sidebar
            $years = Event::public()
                ->selectRaw('YEAR(start_datetime) as year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year');

            $locations = Event::public()
                ->select('location')
                ->whereNotNull('location')
                ->distinct()
                ->orderBy('location')
                ->pluck('location');
                
        } catch (\Exception $e) {
            \Log::error("Error fetching events: " . $e->getMessage());
            $upcomingEvents = collect([]);
            $pastEvents = collect([]);
            $years = collect([]);
            $locations = collect([]);
            $filters = [];
        }
        
        return view('events.index', compact('upcomingEvents', 'pastEvents', 'years', 'locations', 'filters'));
    }

    /**
     * Display the specified event.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        try {
            // Find event by slug - support for multilanguage slugs
            $event = Event::public()
                ->where(function($query) use ($slug) {
                    // Search in all language variations of the slug
                    $query->where('slug->it', $slug)
                          ->orWhere('slug->en', $slug)
                          ->orWhere('slug->de', $slug);
                })
                ->firstOrFail();
                
            // Get related gallery if exists
            $gallery = null;
            if ($event->gallery_id) {
                $gallery = $event->galleryAlbum;
            }
            
            // Format event date for display
            $eventDate = Carbon::parse($event->start_datetime);
            $formattedDate = $eventDate->format('d/m/Y');
            $formattedTime = $eventDate->format('H:i');
            
            // Get related events (same location or similar date)
            $relatedEvents = Event::where('id', '!=', $event->id)
                ->public()
                ->where(function($query) use ($event) {
                    // Same location or within 30 days of this event
                    $query->where('location', $event->location)
                        ->orWhereBetween('start_datetime', [
                            Carbon::parse($event->start_datetime)->subDays(30),
                            Carbon::parse($event->start_datetime)->addDays(30)
                        ]);
                })
                ->orderBy('start_datetime', 'asc')
                ->limit(3)
                ->get();
                
            // Get upcoming events for the sidebar
            $upcomingEvents = Event::public()
                ->upcoming()
                ->orderBy('start_datetime', 'asc')
                ->limit(3)
                ->get();
                
        } catch (\Exception $e) {
            \Log::error("Error fetching event details: " . $e->getMessage());
            abort(404);
        }
        
        return view('events.show', compact(
            'event', 
            'gallery', 
            'formattedDate', 
            'formattedTime', 
            'relatedEvents',
            'upcomingEvents'
        ));
    }
}
