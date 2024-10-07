<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display the unread notifications for the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get unread notifications for the authenticated admin user
        $notifications = Auth::guard('admin')->user()->unreadNotifications;

        // Return the view with the notifications
        return view('backend.notifications.index', compact('notifications'));
    }

    /**
     * Mark a specific notification as read.
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsRead($id)
    {
        // Find the notification by its ID
        $notification = Auth::guard('admin')->user()->notifications()->find($id);

        if ($notification) {
            // Mark the notification as read
            $notification->markAsRead();
        }

        // Redirect back to the notification list or previous page
        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    /**
     * Mark all notifications as read.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAllAsRead()
    {
        // Get all unread notifications and mark them as read
        Auth::guard('admin')->user()->unreadNotifications->markAsRead();

        // Redirect back to the notification list or previous page
        return redirect()->back()->with('success', 'All notifications marked as read.');
    }
}
