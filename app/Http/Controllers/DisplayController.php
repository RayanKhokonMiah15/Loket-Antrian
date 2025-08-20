<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class DisplayController extends Controller
{
    public function index()
    {
        // Ambil tiket yang sedang dipanggil
        $currentTicket = Ticket::where('status', 'called')
            ->orderBy('updated_at', 'desc')
            ->first();

        // Ambil 5 antrian berikutnya yang sedang menunggu
        $waitingTickets = Ticket::where('status', 'waiting')
            ->orderBy('created_at', 'asc')
            ->take(5)
            ->get();

        // Ambil riwayat 5 antrian yang sudah dipanggil
        $recentlyCalled = Ticket::where('status', 'called')
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        // Statistik antrian hari ini
        $stats = [
            'total' => Ticket::whereDate('created_at', today())->count(),
            'waiting' => Ticket::where('status', 'waiting')->count(),
            'called' => Ticket::where('status', 'called')->count(),
            'done' => Ticket::where('status', 'done')->count(),
        ];

        return view('display.index', compact(
            'currentTicket',
            'waitingTickets',
            'recentlyCalled',
            'stats'
        ));
    }

    // Endpoint AJAX untuk update realtime
    public function getUpdates()
    {
        $data = [
            'currentTicket' => Ticket::where('status', 'called')
                ->orderBy('updated_at', 'desc')
                ->first(),
            'waitingTickets' => Ticket::where('status', 'waiting')
                ->orderBy('created_at', 'asc')
                ->take(5)
                ->get(),
            'recentlyCalled' => Ticket::where('status', 'called')
                ->orderBy('updated_at', 'desc')
                ->take(5)
                ->get(),
        ];

        return response()->json($data);
    }
}
