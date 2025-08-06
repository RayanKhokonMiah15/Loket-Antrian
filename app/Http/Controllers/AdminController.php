<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $tickets = Ticket::whereDate('created_at', today())
            ->orderBy('number', 'desc')
            ->get();

        return view('admin.index', compact('tickets'));
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $ticket->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status tiket berhasil diperbarui');
    }
}
