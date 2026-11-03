<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    protected $fillable = [
        'room_name',
        'capacity',
        'location',
        'pic_id',
        'is_active',
    ];

    /**
     * Relasi ke pengguna yang bertugas sebagai PIC ruangan.
     */
    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_id');
    }

    /**
     * Relasi ke agenda peminjaman ruangan.
     */
    public function events()
    {
        return $this->hasMany(Event::class, 'room_id');
    }

    /**
     * Relasi ke laporan kerusakan ruangan.
     */
    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'room_id');
    }
}
