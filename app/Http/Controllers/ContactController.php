<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserContactConfirmation;
use App\Mail\AdminContactInquiry;

class ContactController extends Controller
{
    /**
     * Display all contacts in the admin dashboard.
     */
    public function index()
    {
        // Fetch all contacts, ordered by newest first, paginated at 10 items per page
        $contacts = Contact::latest()->paginate(10);

        return view('backend.pages.contacts.index', compact('contacts'));
    }

    /**
     * Validate the form and save data to the contacts table.
     */
    public function submit(Request $request)
    {
        // 1. Validate the form fields
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'email'   => 'required|email|max:255',
            'message' => 'nullable|string',
        ]);

        // 2. Save data to the contacts table
        $contact = Contact::create([
            'name'    => $validated['name'],
            'mobile'  => $validated['phone'], // Maps 'phone' form field to 'mobile' table column
            'email'   => $validated['email'],
            'message' => $validated['message'] ?? null,
        ]);

        // 3. Prepare data array for email templates
        $data = [
            'name'     => $contact->name,
            'mobile'   => $contact->mobile,
            'email'    => $contact->email,
            'message'  => $contact->message,
            'datetime' => $contact->created_at->format('Y-m-d H:i:s'),
        ];

        // 4. Send Email to User (receipt confirmation)
        Mail::to($contact->email)->send(new UserContactConfirmation($data));

        // 5. Send Email to Admin (inquiry notification)
        $adminEmail = env('ADMIN_MAIL_ADDRESS', 'dharishbandi@gmail.com');
        Mail::to($adminEmail)->send(new AdminContactInquiry($data));

        $successMessage = 'Thank you for contacting GenBright. Your enquiry has been received successfully.';

        // 6. Return response based on request type (supports AJAX/React and traditional blade forms)
        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $successMessage
            ]);
        }

        return back()->with('success', $successMessage);
    }
}
