<?php

namespace Tests\Feature;

use App\Mail\ContactMessageReceived;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ContactPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_page_renders(): void
    {
        $this->get('/kontak')
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page->component('Contact'));
    }

    public function test_valid_submission_is_stored_and_queues_notification(): void
    {
        Mail::fake();

        $response = $this->post('/kontak', [
            'name' => 'Warga Puraseda',
            'email' => 'warga@example.com',
            'message' => 'Halo, saya ingin bertanya tentang layanan desa.',
            'website' => '',
            'rendered_at' => now()->subSeconds(5)->valueOf(),
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Warga Puraseda',
            'email' => 'warga@example.com',
        ]);

        Mail::assertQueued(ContactMessageReceived::class);
    }

    public function test_submission_fails_validation_for_short_message(): void
    {
        $response = $this->post('/kontak', [
            'name' => 'Warga',
            'email' => 'warga@example.com',
            'message' => 'pendek',
            'website' => '',
            'rendered_at' => now()->subSeconds(5)->valueOf(),
        ]);

        $response->assertSessionHasErrors('message');
        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_honeypot_field_rejects_submission(): void
    {
        $response = $this->post('/kontak', [
            'name' => 'Bot',
            'email' => 'bot@example.com',
            'message' => 'Pesan otomatis dari bot spam.',
            'website' => 'http://spam.example.com',
            'rendered_at' => now()->subSeconds(5)->valueOf(),
        ]);

        $response->assertSessionHasErrors('website');
        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_submission_too_fast_after_render_is_rejected(): void
    {
        $response = $this->post('/kontak', [
            'name' => 'Warga Cepat',
            'email' => 'cepat@example.com',
            'message' => 'Pesan yang dikirim terlalu cepat setelah halaman dimuat.',
            'website' => '',
            'rendered_at' => now()->valueOf(),
        ]);

        $response->assertSessionHasErrors('message');
        $this->assertDatabaseCount('contact_messages', 0);
    }
}
