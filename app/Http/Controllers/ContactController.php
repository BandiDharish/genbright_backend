<?php

namespace App\Http\Controllers;

use App\Mail\AdminContactInquiry;
use App\Mail\UserContactConfirmation;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactController extends Controller
{
    /**
     * Display all contacts in the admin dashboard.
     */
    public function index()
    {
        $contacts = Contact::latest()->paginate(10);

        return view('backend.pages.contacts.index', compact('contacts'));
    }

    /**
     * Receive contact form data from React and save it.
     */
    public function submit(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'phone' => [
                'required',
                'string',
                'max:20',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'message' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $contact = Contact::create([
            'name' => $validated['name'],

            // React sends "phone", but database column is "mobile"
            'mobile' => $validated['phone'],

            'email' => $validated['email'],
            'message' => $validated['message'] ?? null,
        ]);

        $mailData = [
            'name' => $contact->name,
            'mobile' => $contact->mobile,
            'email' => $contact->email,
            'message' => $contact->message,
            'datetime' => $contact->created_at->format('Y-m-d H:i:s'),
        ];

        try {
            // Confirmation email to customer
            Mail::to($contact->email)
                ->send(new UserContactConfirmation($mailData));

            // Notification email to administrator
            $adminEmail = config('mail.admin_address');

            Mail::to($adminEmail)
                ->send(new AdminContactInquiry($mailData));
        } catch (Throwable $exception) {
            // Contact data remains saved even when mail sending fails
            Log::error('Contact form email failed.', [
                'contact_id' => $contact->id,
                'error' => $exception->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,

            'message' => 'Thank you for contacting GenBright. Your enquiry has been received successfully.',

            'data' => [
                'id' => $contact->id,
                'name' => $contact->name,
                'phone' => $contact->mobile,
                'email' => $contact->email,
                'message' => $contact->message,
                'created_at' => $contact->created_at,
            ],
        ], 201);
    }
}