<?php

namespace Tests\Feature;

use App\Models\ReceivedEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReceivedEmailDeduplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_message_id_is_only_stored_once(): void
    {
        $attributes = [
            'from_email' => 'sender@example.com',
            'from_name' => 'Sender',
            'subject' => 'Test email',
            'body' => 'Test body',
        ];

        $first = ReceivedEmail::firstOrCreate(
            ['message_id' => 'message-123@example.com'],
            $attributes
        );
        $second = ReceivedEmail::firstOrCreate(
            ['message_id' => 'message-123@example.com'],
            $attributes
        );

        $this->assertTrue($first->wasRecentlyCreated);
        $this->assertFalse($second->wasRecentlyCreated);
        $this->assertDatabaseCount('received_emails', 1);
    }
}