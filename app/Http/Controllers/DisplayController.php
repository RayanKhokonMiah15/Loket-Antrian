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
            ->whereDate('created_at', today())
            ->orderBy('updated_at', 'desc')
            ->first();

        // Ambil 5 antrian berikutnya yang sedang menunggu
        $waitingTickets = Ticket::where('status', 'waiting')
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'asc')
            ->take(5)
            ->get();

        // Ambil riwayat 5 antrian yang sudah dipanggil
        $recentlyCalled = Ticket::where('status', 'called')
            ->whereDate('created_at', today())
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
        // Menggunakan query builder yang lebih efisien
        $today = today();
        
        $query = Ticket::select('id', 'display_number', 'status', 'created_at', 'updated_at')
            ->whereDate('created_at', $today);

        $data = [
            'currentTicket' => (clone $query)
                ->where('status', 'called')
                ->latest('updated_at')
                ->first(),
            'waitingTickets' => (clone $query)
                ->where('status', 'waiting')
                ->oldest('created_at')
                ->take(5)
                ->get(),
            'recentlyCalled' => (clone $query)
                ->where('status', 'called')
                ->latest('updated_at')
                ->take(5)
                ->get(),
        ];

        return response()->json($data)->header('Cache-Control', 'no-store');
    }
}
