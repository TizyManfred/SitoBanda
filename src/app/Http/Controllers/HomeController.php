<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Event;
use DateTime;

class HomeController extends Controller
{
    /**
     * Show the application homepage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Fetch past events from database
        $events = [];
        try {
            // Get past events, ordered by featured status (featured first) and then by date (newest first)
            $events = Event::where('is_public', 1)
                ->where('start_datetime', '<=', now())
                ->orderBy('is_featured', 'desc')
                ->orderBy('start_datetime', 'desc')
                ->get();
        } catch (\Exception $e) {
            // Log the error
            \Log::error("Error fetching events: " . $e->getMessage());
        }

        // Process events data for the template
        $processedEvents = [];
        $delay = 0;
        $delayIncrement = 1; // Increment by 1 for integer operations (will be divided by 10 when used)

        // Fetch upcoming events (today and future)
        try {
            $upcomingEvents = Event::with(['galleryAlbum'])
                ->where('is_public', 1)
                ->where('start_datetime', '>=', now())
                ->orderBy('start_datetime', 'asc')
                ->limit(3)
                ->get();
        } catch (\Exception $e) {
            \Log::error('Error fetching upcoming events: ' . $e->getMessage());
            $upcomingEvents = [];
        }

        foreach ($events as $event) {
            // Format date
            $eventDate = new DateTime($event->start_datetime);
            $formattedDate = $eventDate->format('d/m/Y');
            
            // Animation class (alternate between fadeInLeft and fadeInRight)
            // Multiply by 10 to work with integers and avoid floating-point modulo
            $animationClass = (int)($delay * 10) % 2 == 0 ? 'fadeInLeft' : 'fadeInRight';
            
            // Add featured class if event is featured
            $featuredClass = $event->is_featured ? ' featured-event' : '';
            
            // Store processed event data
            $processedEvents[] = [
                'title' => $event->title,
                'slug' => $event->slug,
                'start_datetime' => $event->start_datetime,
                'formatted_date' => $formattedDate,
                'location' => $event->location ?? '',
                'short_description' => $event->short_description ?? '',
                'image_path' => $event->image_path,
                'is_featured' => $event->is_featured,
                'animation_class' => $animationClass,
                'featured_class' => $featuredClass,
                'delay' => $delay
            ];
            
            // Increment delay for next item (using integer values)
            $delay += $delayIncrement;
        }

        return view('home', compact('processedEvents', 'upcomingEvents'));
    }
}
