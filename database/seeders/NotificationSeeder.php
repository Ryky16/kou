<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first(); // Prend le premier utilisateur pour l’exemple

        DB::table('notifications')->insert([
            'id' => (string) Str::uuid(),
            'type' => 'App\Notifications\CourrierNotification',
            'notifiable_type' => get_class($user),
            'notifiable_id' => $user->id,
            'data' => json_encode([
                'id' => 2,
                'reference' => 'REF-2025-001',
                'objet' => 'Test Notification',
                'expediteur' => 'Secretaire_Municipal',
                'created_at' => now()->format('d/m/Y H:i'),
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
