<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\RepertoireProgram;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Section;
use App\Models\SectionImage;

class PageController extends Controller
{
    /**
     * Show the Chi Siamo page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function chiSiamo()
    {
        return view('pages.chi-siamo');
    }

    /**
     * Show the Storia page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function storia()
    {
        return view('pages.storia');
    }

    /**
     * Show the Organico page with band members organized by section.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function organico()
    {
        try {
            // Eager load sections with their members and images
            $sections = Section::with([
                'members' => function($query) {
                    $query->orderBy('last_name', 'asc')
                          ->orderBy('first_name', 'asc');
                },
                'images' => function($query) {
                    $query->orderBy('display_order', 'asc');
                }
            ])
            ->orderBy('display_order', 'asc')
            ->get();
            
            // Calculate total number of members
            $totalMembers = $sections->sum(function($section) {
                return $section->members ? $section->members->count() : 0;
            });

            return view('pages.organico', [
                'sections' => $sections,
                'totalMembers' => $totalMembers
            ]);
            
        } catch (\Exception $e) {
            // Log the error and return empty data to prevent breaking the page
            \Log::error('Error in PageController@organico: ' . $e->getMessage());
            
            return view('pages.organico', [
                'sections' => collect(),
                'totalMembers' => 0
            ]);
        }
    }

    /**
     * Show the Maestro page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function maestro()
    {
        return view('pages.maestro');
    }

    /**
     * Show the Repertorio page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function repertorio()
    {
        // Get active repertoire programs with their pieces
        $programs = RepertoireProgram::where('is_active', true)
            ->with(['year', 'pieces' => function($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function($program) {
                return $program->year->year;
            });

        // Get upcoming events for sidebar
        $upcomingEvents = Event::upcoming()->take(3)->get();
        
        return view('pages.repertorio', compact('programs', 'upcomingEvents'));
    }

    /**
     * Show the Abito Tradizionale page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function abitoTradizionale()
    {
        return view('pages.abito-tradizionale');
    }

    /**
     * Show the Italia Gira Banda page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function italiaGiraBanda()
    {
        return view('pages.italia-gira-banda');
    }

    /**
     * Show the Corsi di Musica page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function corsiDiMusica()
    {
        return view('pages.corsi-di-musica');
    }

    /**
     * Show the Privacy Policy page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function privacyPolicy()
    {
        return view('pages.privacy-policy');
    }
}
