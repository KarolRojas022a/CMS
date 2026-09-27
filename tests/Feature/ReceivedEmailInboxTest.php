<?php

namespace Tests\Feature;

use App\Models\ReceivedEmail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReceivedEmailInboxTest extends TestCase
{
    use RefreshDatabase;

    public function test_inbox_requires_authentication(): void
    {
        $this->get(route('received-emails.index'))
            ->assertRedirect(route('login'));
    }

    public function test_user_can_list_and_open_a_received_email(): void
    {
        $user = User::factory()->create();
        $email = ReceivedEmail::create([
            'message_id' => 'inbox-message-1@example.com',
            'from_email' => 'sender@example.com',
            'from_name' => 'Sender',
            'subject' => 'Pedido de información',
            'body' => '<script>alert("not executable")</script>Contenido del mensaje',
            'received_at' => now(),
        ]);

        $this->actingAs($user)
            ->get(route('received-emails.index'))
            ->assertOk()
            ->assertSee('Buzón de entrada')
            ->assertSee('Pedido de información')
            ->assertSee('1 sin leer');

        $this->actingAs($user)
            ->get(route('received-emails.show', $email))
            ->assertOk()
            ->assertSee('Contenido del mensaje')
            ->assertSee('&lt;script&gt;', false)
            ->assertDontSee('<script>', false);

        $this->assertDatabaseHas('received_emails', [
            'id' => $email->id,
            'is_read' => true,
        ]);
    }
}