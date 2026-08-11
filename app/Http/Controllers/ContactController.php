<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Contact');
    }

    public function store(ContactRequest $request)
    {
        $contactMessage = ContactMessage::create([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'message' => $request->validated('message'),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        try {
            Mail::to(config('village.contact.email'))->queue(new ContactMessageReceived($contactMessage));
        } catch (\Throwable $e) {
            Log::warning('Gagal mengirim email notifikasi pesan kontak: '.$e->getMessage());
        }

        return back()->with('success', 'Pesan Anda berhasil dikirim. Terima kasih telah menghubungi kami.');
    }
}
