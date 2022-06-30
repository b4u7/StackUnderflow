<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends Controller
{
    public function show(Request $request, string $notificationId): Response
    {
        $notification = $request->user()?->notifications()->findOrFail($notificationId);

        $notification->markAsRead();

        return Inertia::location($notification->data['url']);
    }
}
