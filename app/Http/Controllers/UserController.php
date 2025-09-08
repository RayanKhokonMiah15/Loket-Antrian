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
            // Validasi input
            $request->validate([
                'counter_type' => 'required|in:A,B,C,D'
            ]);
            
            $counterType = $request->counter_type;
            
            // Ambil tiket terakhir untuk hari ini
            $lastTicket = Ticket::where('counter_type', $counterType)
                ->whereDate('created_at', now()->toDateString())
                ->orderBy('created_at', 'desc')
                ->first();

            // Generate nomor baru
            $number = 1;
            if ($lastTicket) {
                $lastNumber = (int) substr($lastTicket->display_number, 1);
                $number = $lastNumber + 1;
            }
            
            // Format nomor display (contoh: A001)
            $displayNumber = $counterType . str_pad($number, 3, '0', STR_PAD_LEFT);
            
            // Cek apakah nomor sudah ada
            $existingTicket = Ticket::where('display_number', $displayNumber)
                ->whereDate('created_at', now()->toDateString())
                ->exists();

            if ($existingTicket) {
                throw new \Exception('Nomor antrian sudah ada, silakan coba lagi.');
            }

            \DB::beginTransaction();
            try {
                // Buat tiket baru
                $ticket = Ticket::create([
                    'display_number' => $displayNumber,
                    'counter_type' => $counterType,
                    'status' => 'waiting'
                ]);
                \DB::commit();

                return response()->json([
                    'success' => true,
                    'display_number' => $ticket->display_number,
                    'counter_type' => $ticket->counter_type
                ]);
            } catch (\Exception $e) {
                \DB::rollback();
                throw $e;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error creating ticket:', [
                'errors' => $e->errors(),
                'counter_type' => $request->counter_type ?? 'not set'
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid: ' . implode(', ', array_map(function($err) { 
                    return implode(', ', $err); 
                }, $e->errors()))
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error creating ticket:', [
                'error' => $e->getMessage(),
                'counter_type' => $request->counter_type ?? 'not set',
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat nomor antrian: ' . ($e->getMessage() === 'Nomor antrian sudah ada, silakan coba lagi.' ? 
                    $e->getMessage() : 'Silakan coba lagi.')
            ], 500);
        }
    }
}
