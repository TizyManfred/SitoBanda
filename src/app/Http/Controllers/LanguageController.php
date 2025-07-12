<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Switch the application language.
     *
     * @param  string  $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switch($locale)
    {
        // Check if the locale is supported
        if (!in_array($locale, ['it', 'en'])) {
            $locale = 'it'; // Default to Italian
        }
        
        // Set the locale
        App::setLocale($locale);
        Session::put('locale', $locale);
        
        // Redirect back to the previous page
        return redirect()->back();
    }
}
