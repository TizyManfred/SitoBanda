<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\RepertoireProgram;
use Illuminate\View\View;

class RepertoireController extends Controller
{
    /**
     * Display the repertoire page.
     */
    public function index(): View
    {
        $programs = RepertoireProgram::with(['pieces' => function ($query) {
                $query->ordered();
            }])
            ->published()
            ->orderBy('year', 'desc')
            ->get()
            ->groupBy('year');

        // Get upcoming events for the sidebar
        $upcomingEvents = Event::public()
            ->upcoming()
            ->orderBy('start_datetime', 'asc')
            ->limit(5)
            ->get();

        return view('pages.repertorio', [
            'programs' => $programs,
            'upcomingEvents' => $upcomingEvents,
        ]);
    }
}
