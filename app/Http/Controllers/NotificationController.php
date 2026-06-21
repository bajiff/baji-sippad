<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Mark all notifications as read.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function readAll(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }

    /**
     * Mark a single notification as read and redirect.
     *
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function read(Request $request, string $id)
    {
        $notification = $request->user()->notifications()->findOrFail($id);

        if (!$notification->read_at) {
            $notification->markAsRead();
        }

        $url = $notification->data['url'] ?? route('landing');

        return redirect($url);
    }
}
