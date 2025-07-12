<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmission;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Display the contact form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contact.index');
    }

    /**
     * Store a new contact form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'subject' => 'required|string|max:200',
            'message' => 'required|string',
            'g-recaptcha-response' => 'required|recaptcha',
        ]);

        if ($validator->fails()) {
            return redirect()->route('contatti')
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Save contact submission to database
            $contact = new Contact();
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->subject = $request->subject;
            $contact->message = $request->message;
            $contact->ip_address = $request->ip();
            $contact->user_agent = $request->userAgent();
            $contact->save();

            // Send email notification
            Mail::to(config('mail.admin_address'))
                ->send(new ContactFormSubmission($contact));

            // Set success message
            return redirect()->route('contatti')
                ->with('success', __('Il tuo messaggio è stato inviato con successo. Ti risponderemo al più presto.'));
        } catch (\Exception $e) {
            \Log::error('Error processing contact form: ' . $e->getMessage());
            
            return redirect()->route('contatti')
                ->with('error', __('Si è verificato un errore durante l\'invio del messaggio. Riprova più tardi.'))
                ->withInput();
        }
    }
}
