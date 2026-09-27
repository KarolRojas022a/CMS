<?php

namespace Tests\Feature;

use App\Mail\ContactMessage;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactSubmissionTest extends TestCase
{
    public function test_success_message_is_visible_after_contact_submission(): void
    {
        Mail::fake();

        $response = $this->from(route('pages.contact'))
            ->followingRedirects()
            ->post(route('contact.send'), [
                'name' => 'Karla',
                'email' => 'karla@example.com',
                'message' => 'Hola, este es un mensaje de prueba.',
            ]);

        $successMessage = config('mail.default') === 'log'
            ? 'Mensaje registrado para pruebas; no se envió por correo.'
            : 'Mensaje enviado correctamente.';

        $response->assertOk()
            ->assertSee($successMessage)
            ->assertSee('alert-success');

        Mail::assertSent(ContactMessage::class);
    }
}