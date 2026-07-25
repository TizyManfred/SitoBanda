<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormSubmission;
use App\Models\Contact;
use App\Services\TurnstileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Display the contact form.
     *
     * @return Response
     */
    public function index()
    {
        return view('contact.index');
    }

    /**
     * Store a new contact form submission.
     *
     * @return Response
     */
    public function store(Request $request, TurnstileService $turnstileService)
    {
        // Determine if the submission comes from the footer quick form
        $fromFooter = (bool) $request->boolean('from_footer');
        $expectsJson = $request->expectsJson();
        $turnstileEnabled = (bool) config('services.turnstile.enabled');

        // Validate form data (footer has fewer fields)
        $rules = [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'message' => 'required|string',
        ];

        if ($turnstileEnabled) {
            $rules['cf-turnstile-response'] = 'required|string|max:2048';
        }

        if (! $fromFooter) {
            $rules['subject'] = 'required|string|max:200';
            $rules['privacy_policy'] = 'accepted';
        } else {
            // Optional phone for footer if we later add it
            $rules['phone'] = 'nullable|string|max:50';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $validationMessage = $validator->errors()->count() === 1
                && $validator->errors()->has('cf-turnstile-response')
                    ? __('contact.messages.turnstile_error')
                    : __('contact.messages.validation_error');

            if ($expectsJson) {
                return response()->json([
                    'message' => $validationMessage,
                    'errors' => $validator->errors(),
                ], 422);
            }

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

        $turnstileAction = $fromFooter ? 'contact_footer' : 'contact_page';

        if ($turnstileEnabled && ! $turnstileService->verify(
            (string) $request->input('cf-turnstile-response'),
            $turnstileAction,
            $request->getHost(),
            $request->ip(),
        )) {
            if ($expectsJson) {
                return response()->json([
                    'message' => __('contact.messages.turnstile_error'),
                    'errors' => [
                        'cf-turnstile-response' => [__('contact.messages.turnstile_error')],
                    ],
                ], 422);
            }

            if ($request->ajax()) {
                return response('MF255', 422);
            }

            $bag = $fromFooter ? 'footer' : 'contact';
            $redirect = $fromFooter ? redirect()->back() : redirect()->route('contatti');

            return $redirect
                ->withErrors([
                    'cf-turnstile-response' => __('contact.messages.turnstile_error'),
                ], $bag)
                ->withInput();
        }

        try {
            // Save contact submission to database
            $contact = new Contact;
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->phone = $request->input('phone');
            $contact->subject = $fromFooter
                ? __('contact.messages.footer_subject')
                : $request->subject;
            $contact->message = $request->message;
            $contact->ip_address = $request->ip();
            $contact->user_agent = $request->userAgent();
            $contact->status = 'new';
            $contact->save();

            // Send email notification
            $adminRecipient = config('mail.admin_address') ?? config('mail.from.address');
            $bccRecipients = collect((array) config('mail.bcc_addresses', []))
                ->map(fn ($address) => trim((string) $address))
                ->filter(fn ($address) => filter_var($address, FILTER_VALIDATE_EMAIL) !== false)
                ->reject(fn ($address) => strcasecmp($address, (string) $adminRecipient) === 0)
                ->unique(fn ($address) => strtolower($address))
                ->values()
                ->all();

            $pendingMail = Mail::to($adminRecipient);

            if ($bccRecipients !== []) {
                $pendingMail->bcc($bccRecipients);
            }

            $pendingMail->send(new ContactFormSubmission($contact, app()->getLocale()));

            // Set success message and redirect appropriately
            $successMsg = __('contact.messages.success');
            if ($expectsJson) {
                return response()->json([
                    'message' => $successMsg,
                ]);
            }

            if ($request->ajax()) {
                // RD Mailform expects a short code on success
                return response('MF000', 200);
            }
            if ($fromFooter) {
                return back()->with('footer_success', $successMsg);
            }

            return redirect()->route('contatti')->with('success', $successMsg);
        } catch (\Exception $e) {
            \Log::error('Error processing contact form: '.$e->getMessage());
            if ($expectsJson) {
                return response()->json([
                    'message' => __('contact.messages.error'),
                ], 500);
            }

            // If AJAX, respond with error code for RD Mailform
            if ($request->ajax()) {
                return response('MF255', 500);
            }
            if ($fromFooter) {
                return back()
                    ->with('footer_error', __('contact.messages.error'))
                    ->withInput();
            }

            return redirect()->route('contatti')
                ->with('error', __('contact.messages.error'))
                ->withInput();
        }
    }
}
