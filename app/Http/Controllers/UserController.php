<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('frontend.user');
    }

    public function createTicket(Request $request)
    {
        try {
            \DB::beginTransaction();

            // Ambil nomor terbesar hari ini
            $lastNumber = Ticket::whereDate('created_at', today())
                                ->max('number');

            // Jika belum ada, mulai dari 1
            $nextNumber = $lastNumber ? $lastNumber + 1 : 1;

            // Buat ticket baru dengan nomor berurutan
            $ticket = Ticket::create([
                'prefix' => 'A',
                'number' => $nextNumber,
                'status' => 'waiting',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            \DB::commit();

            $formattedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            return response()->json([
                'success' => true,
                'ticket' => $formattedNumber,
                'message' => 'Nomor antrian berhasil dibuat'
            ], 200);
            
        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membuat nomor antrian'
            ], 500);
        }
    }
}
