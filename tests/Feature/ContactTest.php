<?php

namespace Tests\Feature;

use App\Mail\NewLeadNotification;
use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_valid_submission_creates_a_lead_and_queues_an_email(): void
    {
        Mail::fake();

        $response = $this->post(route('contact.store'), [
            'name' => 'Jean Dupont',
            'email' => 'jean@example.com',
            'message' => 'Bonjour, je souhaite échanger sur un projet de transformation digitale.',
        ]);

        $response->assertRedirect(route('contact'));

        $this->assertDatabaseHas('leads', [
            'name' => 'Jean Dupont',
            'email' => 'jean@example.com',
        ]);

        Mail::assertQueued(NewLeadNotification::class);
    }

    public function test_an_invalid_submission_is_rejected(): void
    {
        $response = $this->post(route('contact.store'), [
            'name' => '',
            'email' => 'not-an-email',
            'message' => 'Trop court',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
        $this->assertDatabaseCount('leads', 0);
    }

    public function test_a_submission_with_a_filled_honeypot_is_rejected(): void
    {
        $response = $this->post(route('contact.store'), [
            'name' => 'Spam Bot',
            'email' => 'bot@example.com',
            'message' => 'Ceci est un message envoyé par un robot spammeur.',
            'website' => 'https://spam.example.com',
        ]);

        $response->assertSessionHasErrors(['website']);
        $this->assertDatabaseCount('leads', 0);
    }
}
