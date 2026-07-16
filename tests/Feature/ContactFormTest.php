<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Mail;
use App\Mail\UserContactConfirmation;
use App\Mail\AdminContactInquiry;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the contact form requires name, phone, and email.
     */
    public function test_contact_form_requires_mandatory_fields()
    {
        $response = $this->postJson(route('contact.submit'), []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'phone', 'email']);
    }

    /**
     * Test that a valid email address is required.
     */
    public function test_contact_form_requires_valid_email()
    {
        $response = $this->postJson(route('contact.submit'), [
            'name' => 'John Doe',
            'phone' => '1234567890',
            'email' => 'invalid-email',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    /**
     * Test successful contact form submission saves to DB and sends emails (JSON AJAX request).
     */
    public function test_successful_contact_submission_saves_and_sends_emails()
    {
        Mail::fake();

        $response = $this->postJson(route('contact.submit'), [
            'name' => 'John Doe',
            'phone' => '1234567890',
            'email' => 'johndoe@example.com',
            'message' => 'Hello GenBright, this is a test inquiry.',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Thank you for contacting GenBright. Your enquiry has been received successfully.'
        ]);

        // Assert database has the contact record
        $this->assertDatabaseHas('contacts', [
            'name' => 'John Doe',
            'mobile' => '1234567890',
            'email' => 'johndoe@example.com',
            'message' => 'Hello GenBright, this is a test inquiry.',
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
            'name' => 'Jane Smith',
            'phone' => '9876543210',
            'email' => 'janesmith@example.com',
            'message' => 'I would like to inquire about admissions.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Thank you for contacting GenBright. Your enquiry has been received successfully.');

        // Assert database has the contact record
        $this->assertDatabaseHas('contacts', [
            'name' => 'Jane Smith',
            'mobile' => '9876543210',
            'email' => 'janesmith@example.com',
            'message' => 'I would like to inquire about admissions.',
        ]);

        Mail::assertSent(UserContactConfirmation::class);
        Mail::assertSent(AdminContactInquiry::class);
    }

    /**
     * Test guest cannot access the admin contacts listing page.
     */
    public function test_guest_cannot_access_admin_contacts_list()
    {
        $response = $this->get(route('admin.contacts.index'));

        $response->assertRedirect(route('admin.login'));
    }

    /**
     * Test authenticated admin can view the contacts listing page.
     */
    public function test_admin_can_view_contacts_list()
    {
        // Create an admin user
        $admin = User::factory()->create();

        // Create some contact records
        for ($i = 0; $i < 15; $i++) {
            Contact::create([
                'name' => "User $i",
                'mobile' => "123456789$i",
                'email' => "user$i@example.com",
                'message' => "Message $i",
            ]);
        }

        $response = $this->actingAs($admin)
            ->get(route('admin.contacts.index'));

        $response->assertStatus(200);
        $response->assertViewIs('backend.pages.contacts.index');
        $response->assertViewHas('contacts');

        // Verify pagination is passed and limits to 10 contacts per page
        $contacts = $response->viewData('contacts');
        $this->assertCount(10, $contacts);
    }
}
