<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\UserContactConfirmation;
use App\Mail\AdminContactInquiry;
use Exception;

class ContactController extends Controller
{
    /**
     * Handle the contact form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function submit(Request $request)
    {
        // 1. Validate the form fields as required
        $validated = $request->validate([
            'full_name'     => 'required|string|max:255',
            'mobile_number' => 'required|string|max:20',
            'email_address' => 'required|email|max:255',
            'message'       => 'nullable|string|max:5000',
        ]);

        try {
            // 2. Prepare unified data array for email templates
            $data = [
                'name'     => $validated['full_name'],
                'mobile'   => $validated['mobile_number'],
                'email'    => $validated['email_address'],
                'message'  => $validated['message'] ?? null,
                'datetime' => now()->timezone(config('app.timezone', 'UTC'))->format('Y-m-d H:i:s T'),
            ];

            // 3. Send Email 1 (To User)
            Mail::to($validated['email_address'])->send(new UserContactConfirmation($data));

            // 4. Send Email 2 (To Admin)
            // Recipient is configured in .env (defaults to dharishbandi@gmail.com)
            $adminEmail = env('ADMIN_MAIL_ADDRESS', 'dharishbandi@gmail.com');
            Mail::to($adminEmail)->send(new AdminContactInquiry($data));

            $successMessage = 'Thank you for contacting GenBright. Your enquiry has been received successfully.';

            // 5. Return response based on client preferences (supports AJAX/JSON)
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage
                ]);
            }

            return back()->with('success', $successMessage);

        } catch (Exception $e) {
            // 6. Handle errors using try-catch and log the exception with context
            Log::error('GenBright Contact Form Error: ' . $e->getMessage(), [
                'exception' => $e,
                'payload'   => $request->only(['full_name', 'email_address', 'mobile_number'])
            ]);

            $errorMessage = 'We encountered an error while processing your inquiry. Please try again later.';

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 500);
            }

            return back()->withInput()->with('error', $errorMessage);
        }
    }
}
