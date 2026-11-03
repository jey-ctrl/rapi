<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Menampilkan halaman kalender publik.
     */
    public function index()
    {
        return view('calendar.index');
    }

    /**
     * Mengambil agenda menunggu dan disetujui
     * untuk ditampilkan di kalender publik.
     */
    public function events(Request $request)
    {
        $query = Event::with('room')
            ->whereNotNull('date')
            ->whereNotNull('start_time')
            ->whereNotNull('end_time')
            ->whereIn('status', [
                'pending',
                'menunggu',
                'menunggu persetujuan',
                'disetujui',
                'approved',
                'setuju',
            ]);

        // Filter tanggal awal dari FullCalendar.
        if ($request->filled('start')) {
            $query->whereDate('date', '>=', $request->start);
        }

        // Filter tanggal akhir.
        // FullCalendar mengirim tanggal akhir secara eksklusif.
        if ($request->filled('end')) {
            $query->whereDate('date', '<', $request->end);
        }

        $events = $query->get();

        $data = $events->map(function ($event) {
            $status = strtolower(trim((string) $event->status));

            $isApproved = in_array($status, [
                'disetujui',
                'approved',
                'setuju',
            ], true);

            // Hijau untuk disetujui, oranye untuk menunggu.
            $color = $isApproved
                ? '#198754'
                : '#f0ad4e';

            return [
                'id' => $event->id,

                'title' => $event->event_name,

                'start' => $event->date . 'T'
                    . $event->start_time,

                'end' => $event->date . 'T'
                    . $event->end_time,

                'backgroundColor' => $color,
                'borderColor' => $color,
                'textColor' => $isApproved ? '#ffffff' : '#263445',

                'extendedProps' => [
                    'room' => $event->room->room_name
                        ?? 'Ruangan tidak ditemukan',

                    'status' => $event->status,
                    'date' => $event->date,
                    'start_time' => $event->start_time,
                    'end_time' => $event->end_time,
                ],
            ];
        });

        return response()->json($data);
    }
}
