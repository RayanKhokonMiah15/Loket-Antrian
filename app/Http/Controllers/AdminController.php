<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::whereDate('created_at', now()->toDateString());

        // Filter status jika ada
        if ($request->get('filter') === 'called') {
            $query->where('status', 'called');
        } elseif ($request->get('filter') === 'done') {
            $query->where('status', 'done');
        }

        // Filter loket jika ada
        if ($request->has('loket') && in_array($request->get('loket'), ['A','B','C','D'])) {
            $query->where('loket', $request->get('loket'));
        }

        $tickets = $query->orderBy('created_at', 'desc')->get();

        return view('admin.index', compact('tickets'));
    }

    public function loketA(Request $request)
    {
        $tickets = Ticket::where('loket', 'A')->whereDate('created_at', now()->toDateString())->orderBy('created_at', 'desc')->get();
        return view('admin.loketA', compact('tickets'));
    }

    public function loketB(Request $request)
    {
        $tickets = Ticket::where('loket', 'B')->whereDate('created_at', now()->toDateString())->orderBy('created_at', 'desc')->get();
        return view('admin.loketB', compact('tickets'));
    }

    public function loketC(Request $request)
    {
        $tickets = Ticket::where('loket', 'C')->whereDate('created_at', now()->toDateString())->orderBy('created_at', 'desc')->get();
        return view('admin.loketC', compact('tickets'));
    }

    public function loketD(Request $request)
    {
        $tickets = Ticket::where('loket', 'D')->whereDate('created_at', now()->toDateString())->orderBy('created_at', 'desc')->get();
        return view('admin.loketD', compact('tickets'));
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
