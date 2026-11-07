<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return view('calendar.auth');
        }

        return view('calendar.index');
    }

    public function events(Request $request)
    {
        $query = Event::with(['room', 'applicant'])
            ->whereNotNull('date')
            ->whereNotNull('start_time')
            ->whereNotNull('end_time')
            ->whereIn('status', [
                'pending',
                'menunggu',
                'menunggu persetujuan',
                'approved',
                'disetujui',
                'setuju',
            ]);

        if ($request->filled('start')) {
            $query->whereDate('date', '>=', $request->start);
        }

        if ($request->filled('end')) {
            $query->whereDate('date', '<', $request->end);
        }

        $events = $query
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        $categoryColors = [
            'Kegiatan Guru' => '#2457a7',
            'Kegiatan Siswa' => '#198754',
            'Kegiatan Organisasi' => '#805ad5',
            'Rapat' => '#0d9488',
            'Kegiatan Sekolah' => '#d97706',
            'Lainnya' => '#64748b',
        ];

        $eventData = $events->map(function ($event) use ($categoryColors) {
            $status = strtolower(trim((string) $event->status));

            $isApproved = in_array($status, [
                'approved',
                'disetujui',
                'setuju',
            ], true);

            $color = $isApproved
                ? ($categoryColors[$event->category] ?? '#64748b')
                : '#f0ad4e';

            return [
                'id' => 'event-' . $event->events_id,
                'title' => $event->event_name,
                'start' => $event->date . 'T' . $event->start_time,
                'end' => $event->date . 'T' . $event->end_time,
                'backgroundColor' => $color,
                'borderColor' => $color,
                'textColor' => '#ffffff',

                'extendedProps' => [
                    'room' => $event->room->room_name ?? 'Ruangan tidak ditemukan',
                    'date' => $event->date,
                    'start_time' => $event->start_time,
                    'end_time' => $event->end_time,
                    'applicant' => $event->applicant->fullname ?? 'Tidak diketahui',
                    'description' => $event->description ?? '',
                    'category' => $event->category ?? 'Lainnya',
                    'status' => $event->status,
                    'isNationalCalendar' => false,
                ],
            ];
        });

        $nationalEvents = collect(config('calendar.events', []))
            ->filter(function ($holiday, $date) use ($request) {
                if ($request->filled('start') && $date < $request->start) {
                    return false;
                }

                if ($request->filled('end') && $date >= $request->end) {
                    return false;
                }

                return true;
            })
            ->map(function ($holiday, $date) {
                $type = $holiday['type'];

                $colors = [
                    'national_holiday' => '#dc3545',
                    'collective_leave' => '#d97706',
                    'national_day' => '#2457a7',
                ];

                return [
                    'id' => 'national-' . $date,
                    'title' => $holiday['name'],
                    'start' => $date,
                    'allDay' => true,
                    'backgroundColor' => $colors[$type] ?? '#2457a7',
                    'borderColor' => $colors[$type] ?? '#2457a7',
                    'textColor' => '#ffffff',

                    'extendedProps' => [
                        'date' => $date,
                        'nationalType' => $type,
                        'isNationalCalendar' => true,
                    ],
                ];
            });

        $result = $eventData
            ->concat($nationalEvents)
            ->values();

        return response()->json($result);
    }
}
