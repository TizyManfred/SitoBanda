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
        // Determine if the submission comes from the footer quick form
        $fromFooter = (bool) $request->boolean('from_footer');

        // Validate form data (footer has fewer fields)
        $rules = [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'message' => 'required|string',
        ];

        if (!$fromFooter) {
            $rules['subject'] = 'required|string|max:200';
            $rules['privacy_policy'] = 'accepted';
            // reCAPTCHA temporarily disabled
            // $rules['g-recaptcha-response'] = 'required|recaptcha';
        } else {
            // Optional phone for footer if we later add it
            $rules['phone'] = 'nullable|string|max:50';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // If this is an AJAX submission (RD Mailform), return a short error code
            if ($request->ajax()) {
                return response('MF255', 422);
            }
            $bag = $fromFooter ? 'footer' : 'contact';
            $redirect = $fromFooter ? redirect()->back() : redirect()->route('contatti');
            return $redirect
                ->withErrors($validator, $bag)
                ->withInput();
        }

        try {
            // Save contact submission to database
            $contact = new Contact();
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->phone = $request->input('phone');
            $contact->subject = $fromFooter
                ? __('Nuovo messaggio dal form nel footer')
                : $request->subject;
            $contact->message = $request->message;
            $contact->ip_address = $request->ip();
            $contact->user_agent = $request->userAgent();
            $contact->status = 'new';
            $contact->save();

            // Send email notification
            $adminRecipient = config('mail.admin_address') ?? config('mail.from.address');
            Mail::to($adminRecipient)
                ->send(new ContactFormSubmission($contact));

            // Set success message and redirect appropriately
            $successMsg = __('Il tuo messaggio è stato inviato con successo. Ti risponderemo al più presto.');
            if ($request->ajax()) {
                // RD Mailform expects a short code on success
                return response('MF000', 200);
            }
            if ($fromFooter) {
                return back()->with('footer_success', $successMsg);
            }
            return redirect()->route('contatti')->with('success', $successMsg);
        } catch (\Exception $e) {
            \Log::error('Error processing contact form: ' . $e->getMessage());
            // If AJAX, respond with error code for RD Mailform
            if ($request->ajax()) {
                return response('MF255', 500);
            }
            if ($fromFooter) {
                return back()
                    ->with('footer_error', __('Si è verificato un errore durante l\'invio del messaggio. Riprova più tardi.'))
                    ->withInput();
            }
            return redirect()->route('contatti')
                ->with('error', __('Si è verificato un errore durante l\'invio del messaggio. Riprova più tardi.'))
                ->withInput();
        }
    }
}
