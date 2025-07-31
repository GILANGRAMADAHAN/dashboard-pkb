<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'type',
        'message',
        'data',
        'is_read',
        'read_at'
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime'
    ];

    public static function createNotification($type, $message, $data = null)
    {
        return self::create([
            'type' => $type,
            'message' => $message,
            'data' => $data,
            'is_read' => false
        ]);
    }

    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    public static function getUnreadCount()
    {
        return self::where('is_read', false)->count();
    }

    public static function getUnreadNotifications()
    {
        return self::where('is_read', false)
                   ->orderBy('created_at', 'desc')
                   ->get();
    }
}
