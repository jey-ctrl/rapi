<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table = 'complaints';

    protected $fillable = [
        'room_id',
        'reporter_id',
        'event_id',
        'description',
        'photo_path',
        'status_repair',
        'reported_at',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'events_id');
    }
}
