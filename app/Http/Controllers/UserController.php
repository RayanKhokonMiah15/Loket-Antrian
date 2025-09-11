<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }

    public function createTicket(Request $request)
    {
        try {
            // Validasi input dengan caching
            $validator = validator()->make($request->all(), [
                'counter_type' => 'required|in:A,B,C,D'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak valid'
                ], 422);
            }
            
            // Gunakan lock optimistic dengan retry terbatas
            $maxAttempts = 3;
            $attempt = 1;
            
            while ($attempt <= $maxAttempts) {
                try {
                    $ticket = DB::transaction(function() use ($request) {
                        $counterType = $request->counter_type;
                        $today = now()->toDateString();
                        
                        // Gunakan cache untuk nomor terakhir jika tersedia
                        $cacheKey = "last_number_{$counterType}_{$today}";
                        $lastNumber = cache()->remember($cacheKey, now()->endOfDay(), function() use ($counterType, $today) {
                            return Ticket::where('counter_type', $counterType)
                                ->whereDate('created_at', $today)
                                ->max('number') ?? 0;
                        });
                        
                        // Increment nomor
                        $number = $lastNumber + 1;
                        
                        // Format nomor display (contoh: A001)
                        $displayNumber = $counterType . str_pad($number, 3, '0', STR_PAD_LEFT);
                        
                        // Buat tiket baru dengan eager loading
                        $ticket = Ticket::create([
                            'display_number' => $displayNumber,
                            'counter_type' => $counterType,
                            'status' => 'waiting',
                            'number' => $number
                        ]);
                        
                        // Update cache
                        cache()->put($cacheKey, $number, now()->endOfDay());
                        
                        return $ticket;
                    }, 3); // Retry 3 kali jika terjadi deadlock
                    
                    break; // Keluar dari loop jika berhasil
                } catch (\Exception $e) {
                    if ($attempt === $maxAttempts) {
                        throw $e;
                    }
                    $attempt++;
                    usleep(50000); // Tunggu 50ms sebelum mencoba lagi
                }
            }

            return response()->json([
                'success' => true,
                'display_number' => $ticket->display_number,
                'counter_type' => $ticket->counter_type
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error creating ticket:', [
                'errors' => $e->errors(),
                'counter_type' => $request->counter_type ?? 'not set'
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid'
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error creating ticket:', [
                'error' => $e->getMessage(),
                'counter_type' => $request->counter_type ?? 'not set'
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat nomor antrian. Silakan coba lagi.'
            ], 500);
        }
    }
}
