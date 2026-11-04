<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'room_id',
        'reporter_id',
        'description',
        'photo_path',
        'status_repair',
        'handler_id',
        'reported_at'
    ];

    
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }
    public function handler()
    {
        return $this->belongsTo(User::class, 'handler_id');
    }
}
