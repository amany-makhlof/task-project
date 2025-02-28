<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminNotificationController extends Controller
{
    /**
     * Get unread notifications for the logged-in Admin
     */
    public function unreadNotifications()
    {
        $admin = Auth::user();

        // تأكد أن المستخدم لديه دور "Admin"
        if (!$admin->hasRole('Admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'status' => true,
            'notifications' => $admin->unreadNotifications
        ]);
    }

    /**
     * Mark notifications as read
     */
    public function markAsRead($id)
    {
        $admin = Auth::user();

        // التأكد أن المستخدم لديه دور "Admin"
        if (!$admin->hasRole('Admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // البحث عن الإشعار المحدد وتحديثه كمقروء
        $notification = $admin->notifications()->where('id', $id)->first();

        if (!$notification) {
            return response()->json(['message' => 'Notification not found'], 404);
        }

        $notification->markAsRead();

        return response()->json(['message' => 'Notification marked as read']);
    }
}
