<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Mail;
use App\Mail\UserContactConfirmation;
use App\Mail\AdminContactInquiry;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    /**
     * Test that the contact form requires full name, mobile, and email.
     */
    public function test_contact_form_requires_mandatory_fields()
    {
        $response = $this->postJson(route('contact.submit'), []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['full_name', 'mobile_number', 'email_address']);
    }

    /**
     * Test that a valid email address is required.
     */
    public function test_contact_form_requires_valid_email()
    {
        $response = $this->postJson(route('contact.submit'), [
            'full_name' => 'John Doe',
            'mobile_number' => '1234567890',
            'email_address' => 'invalid-email',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email_address']);
    }

    /**
     * Test successful contact form submission sends emails (JSON AJAX request).
     */
    public function test_successful_contact_submission_sends_emails()
    {
        Mail::fake();

        $response = $this->postJson(route('contact.submit'), [
            'full_name' => 'John Doe',
            'mobile_number' => '1234567890',
            'email_address' => 'johndoe@example.com',
            'message' => 'Hello GenBright, this is a test inquiry.',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Thank you for contacting GenBright. Your enquiry has been received successfully.'
        ]);

        // Assert Email 1 (To User) was sent
        Mail::assertSent(UserContactConfirmation::class, function ($mail) {
            return $mail->hasTo('johndoe@example.com') &&
                   $mail->data['name'] === 'John Doe' &&
                   $mail->data['mobile'] === '1234567890' &&
                   $mail->data['email'] === 'johndoe@example.com' &&
                   $mail->data['message'] === 'Hello GenBright, this is a test inquiry.';
        });

        // Assert Email 2 (To Admin) was sent
        $adminEmail = env('ADMIN_MAIL_ADDRESS', 'dharishbandi@gmail.com');
        Mail::assertSent(AdminContactInquiry::class, function ($mail) use ($adminEmail) {
            return $mail->hasTo($adminEmail) &&
                   $mail->data['name'] === 'John Doe' &&
                   $mail->data['mobile'] === '1234567890' &&
                   $mail->data['email'] === 'johndoe@example.com' &&
                   $mail->data['message'] === 'Hello GenBright, this is a test inquiry.';
        });
    }

    /**
     * Test that standard form submission redirects back with success message.
     */
    public function test_standard_form_submission_redirects_back_with_success()
    {
        Mail::fake();

        $response = $this->post(route('contact.submit'), [
            'full_name' => 'Jane Smith',
            'mobile_number' => '9876543210',
            'email_address' => 'janesmith@example.com',
            'message' => 'I would like to inquire about admissions.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Thank you for contacting GenBright. Your enquiry has been received successfully.');

        Mail::assertSent(UserContactConfirmation::class);
        Mail::assertSent(AdminContactInquiry::class);
    }
}
