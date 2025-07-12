<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Section;

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
            // Get all sections with their members, ordered by display_order
            $sections = Section::with(['members' => function($query) {
                $query->orderBy('display_order', 'asc');
            }])
            ->orderBy('display_order', 'asc')
            ->get();
        } catch (\Exception $e) {
            \Log::error("Error fetching organico data: " . $e->getMessage());
            $sections = [];
        }

        return view('pages.organico', compact('sections'));
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
        return view('pages.repertorio');
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
