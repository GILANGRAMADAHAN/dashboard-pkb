<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        // Hanya super admin yang bisa melihat notifikasi
        if (!auth()->user() || !auth()->user()->isSuperAdmin()) {
            abort(403, 'Akses ditolak');
        }

        $query = Notification::query();

        // Filter berdasarkan status
        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->status === 'read') {
                $query->where('is_read', true);
            }
        }

        // Filter berdasarkan tipe
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $notifications = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('notifications.index', compact('notifications'));
    }

    public function getUnreadCount()
    {
        // Hanya super admin yang bisa melihat notifikasi
        if (!auth()->user() || !auth()->user()->isSuperAdmin()) {
            return response()->json(['count' => 0]);
        }

        $count = Notification::getUnreadCount();
        return response()->json(['count' => $count]);
    }

    public function getUnreadNotifications()
    {
        // Hanya super admin yang bisa melihat notifikasi
        if (!auth()->user() || !auth()->user()->isSuperAdmin()) {
            return response()->json(['notifications' => []]);
        }

        $notifications = Notification::getUnreadNotifications();
        return response()->json(['notifications' => $notifications]);
    }

    public function getLatestNotification()
    {
        // Hanya super admin yang bisa melihat notifikasi
        if (!auth()->user() || !auth()->user()->isSuperAdmin()) {
            return response()->json(['notification' => null]);
        }

        $notification = Notification::where('is_read', false)
                                   ->orderBy('created_at', 'desc')
                                   ->first();
        
        return response()->json(['notification' => $notification]);
    }

    public function markAsRead($id)
    {
        // Hanya super admin yang bisa mengubah notifikasi
        if (!auth()->user() || !auth()->user()->isSuperAdmin()) {
            abort(403, 'Akses ditolak');
        }

        $notification = Notification::findOrFail($id);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        // Hanya super admin yang bisa mengubah notifikasi
        if (!auth()->user() || !auth()->user()->isSuperAdmin()) {
            abort(403, 'Akses ditolak');
        }

        Notification::where('is_read', false)->update([
            'is_read' => true,
            'read_at' => now()
        ]);

        return response()->json(['success' => true]);
    }

    public function clearAllNotifications()
    {
        // Hanya super admin yang bisa menghapus notifikasi
        if (!auth()->user() || !auth()->user()->isSuperAdmin()) {
            abort(403, 'Akses ditolak');
        }

        // Hapus semua notifikasi
        Notification::truncate();

        return response()->json(['success' => true]);
    }

    public function clearReadNotifications()
    {
        // Hanya super admin yang bisa menghapus notifikasi
        if (!auth()->user() || !auth()->user()->isSuperAdmin()) {
            abort(403, 'Akses ditolak');
        }

        // Hapus hanya notifikasi yang sudah dibaca
        Notification::where('is_read', true)->delete();

        return response()->json(['success' => true]);
    }

    public function deleteNotification($id)
    {
        // Hanya super admin yang bisa menghapus notifikasi
        if (!auth()->user() || !auth()->user()->isSuperAdmin()) {
            abort(403, 'Akses ditolak');
        }

        $notification = Notification::findOrFail($id);
        $notification->delete();

        return response()->json(['success' => true]);
    }

    public function exportPdf(Request $request)
    {
        // Hanya super admin yang bisa mengekspor notifikasi
        if (!auth()->user() || !auth()->user()->isSuperAdmin()) {
            abort(403, 'Akses ditolak');
        }

        $query = Notification::query();

        // Filter berdasarkan status
        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->status === 'read') {
                $query->where('is_read', true);
            }
        }

        // Filter berdasarkan tipe
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $notifications = $query->orderBy('created_at', 'desc')->get();
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('notifications.pdf', compact('notifications'));
        return $pdf->download('notifikasi-' . date('Y-m-d') . '.pdf');
    }
}
