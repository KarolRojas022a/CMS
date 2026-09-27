<?php

namespace App\Http\Controllers;

use App\Models\ReceivedEmail;
use Illuminate\View\View;

class ReceivedEmailController extends Controller
{
    public function index(): View
    {
        return view('received-emails.index', [
            'emails' => ReceivedEmail::query()
                ->orderByDesc('received_at')
                ->orderByDesc('id')
                ->paginate(20),
            'unreadCount' => ReceivedEmail::query()
                ->where('is_read', false)
                ->count(),
        ]);
    }

    public function show(ReceivedEmail $receivedEmail): View
    {
        if (! $receivedEmail->is_read) {
            $receivedEmail->update(['is_read' => true]);
        }

        return view('received-emails.show', [
            'email' => $receivedEmail,
        ]);
    }
}
