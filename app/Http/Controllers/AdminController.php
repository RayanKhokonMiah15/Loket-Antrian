<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::whereDate('created_at', today());

        if ($request->get('filter') === 'called') {
            $query->where('status', 'called');
        } elseif ($request->get('filter') === 'done') {
            $query->where('status', 'done');
        }

        $tickets = $query->orderBy('number', 'desc')->get();

        return view('admin.index', compact('tickets'));
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        // Validasi & fallback supaya tidak pernah NULL
        $request->validate([
            'status' => 'nullable|in:waiting,called,done,cancelled',
        ]);

        $status = $request->input('status', 'called'); // default ke "called" bila kosong

        $ticket->update([
            'status' => $status,
        ]);

        return redirect()->back()->with('success', 'Status tiket berhasil diperbarui');
    }
}
