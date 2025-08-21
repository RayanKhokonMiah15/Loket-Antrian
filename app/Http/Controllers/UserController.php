<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }

    public function createTicket(Request $request)
    {
        try {
            $request->validate([
                'counter_type' => 'required|in:A,B,C,D'
            ]);
            
            $counterType = $request->input('counter_type');
            
            // Get last ticket number for this counter type today
            $lastTicket = Ticket::where('counter_type', $counterType)
                ->whereDate('created_at', Carbon::today())
                ->latest()
                ->first();

            $number = $lastTicket ? (int)substr($lastTicket->display_number, 1) + 1 : 1;
            
            $ticket = new Ticket();
            $ticket->display_number = $counterType . str_pad($number, 3, '0', STR_PAD_LEFT);
            $ticket->counter_type = $counterType;
            $ticket->status = 'waiting';
            $ticket->save();

            return response()->json([
                'success' => true,
                'display_number' => $ticket->display_number,
                'counter_type' => $ticket->counter_type
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating ticket: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membuat nomor antrian'
            ], 500);
        }
    }
}
