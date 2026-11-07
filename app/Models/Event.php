<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Room;
use App\Models\User;

class Event extends Model
{
    protected $table = 'events';

    protected $primaryKey = 'events_id';

    protected $fillable = [
        'room_id',
        'pic_id',
        'event_name',
        'category',
        'description',
        'date',
        'start_time',
        'end_time',
        'status',
        'approve_by',
        'move_reason',
        'rejection_reason',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function applicant()
    {
        return $this->belongsTo(User::class, 'pic_id');
    }

    public function isMoved()
    {
        return !is_null($this->move_reason)
            && $this->move_reason !== '';
    }
}
