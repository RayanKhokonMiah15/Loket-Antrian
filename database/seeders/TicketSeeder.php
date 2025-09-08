<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $today = now();

        // Counter A - 3 waiting tickets
        for ($i = 1; $i <= 3; $i++) {
            Ticket::create([
                'display_number' => 'A' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'counter_type' => 'A',
                'status' => 'waiting',
                'created_at' => $today->copy()->addMinutes($i * 5),
                'updated_at' => $today->copy()->addMinutes($i * 5)
            ]);
        }

        // Counter B - 2 called tickets
        for ($i = 1; $i <= 2; $i++) {
            Ticket::create([
                'display_number' => 'B' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'counter_type' => 'B',
                'status' => 'called',
                'created_at' => $today->copy()->addMinutes($i * 5),
                'updated_at' => $today->copy()->addMinutes($i * 5)
            ]);
        }

        // Counter C - 2 done tickets
        for ($i = 1; $i <= 2; $i++) {
            Ticket::create([
                'display_number' => 'C' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'counter_type' => 'C',
                'status' => 'done',
                'created_at' => $today->copy()->addMinutes($i * 5),
                'updated_at' => $today->copy()->addMinutes($i * 5)
            ]);
        }

        // Counter D - Mix of statuses
        Ticket::create([
            'display_number' => 'D001',
            'counter_type' => 'D',
            'status' => 'waiting',
            'created_at' => $today->copy()->addMinutes(30),
            'updated_at' => $today->copy()->addMinutes(30)
        ]);

        Ticket::create([
            'display_number' => 'D002',
            'counter_type' => 'D',
            'status' => 'called',
            'created_at' => $today->copy()->addMinutes(35),
            'updated_at' => $today->copy()->addMinutes(35)
        ]);
    }
}
