<?php

namespace Database\Seeders;

use App\Models\Field;
use App\Models\FieldType;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ──────────────────────────────────────────────
        User::create([
            'name'              => 'Administrator',
            'email'             => 'admin@sportbook.com',
            'password'          => bcrypt('password'),
            'role'              => 'admin',
            'phone'             => '081234567890',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'              => 'User Demo',
            'email'             => 'user@sportbook.com',
            'password'          => bcrypt('password'),
            'role'              => 'user',
            'phone'             => '089876543210',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'              => 'Budi Santoso',
            'email'             => 'budi@example.com',
            'password'          => bcrypt('password'),
            'role'              => 'user',
            'phone'             => '081111222333',
            'email_verified_at' => now(),
        ]);

        // ── Field Types ────────────────────────────────────────
        $futsal    = FieldType::create(['name' => 'Futsal',    'icon' => null]);
        $badminton = FieldType::create(['name' => 'Badminton', 'icon' => null]);
        $basket    = FieldType::create(['name' => 'Basket',    'icon' => null]);

        // ── Fields ─────────────────────────────────────────────
        // Futsal (2 lapangan)
        Field::create([
            'field_type_id' => $futsal->id,
            'name'          => 'Futsal A',
            'price_offpeak' => 80000,
            'price_peak'    => 120000,
            'description'   => 'Lapangan futsal dengan lantai vinyl berkualitas tinggi. Kapasitas 10 pemain.',
            'is_active'     => true,
        ]);
        Field::create([
            'field_type_id' => $futsal->id,
            'name'          => 'Futsal B',
            'price_offpeak' => 80000,
            'price_peak'    => 120000,
            'description'   => 'Lapangan futsal indoor berpendingin udara. Cocok untuk turnamen.',
            'is_active'     => true,
        ]);

        // Badminton (4 lapangan)
        foreach (range(1, 4) as $i) {
            Field::create([
                'field_type_id' => $badminton->id,
                'name'          => "Badminton {$i}",
                'price_offpeak' => 50000,
                'price_peak'    => 75000,
                'description'   => "Lapangan badminton {$i} dengan lantai kayu parket standar BWF.",
                'is_active'     => true,
            ]);
        }

        // Basket (1 lapangan)
        Field::create([
            'field_type_id' => $basket->id,
            'name'          => 'Basket Utama',
            'price_offpeak' => 100000,
            'price_peak'    => 150000,
            'description'   => 'Lapangan basket full court dengan ring standar NBA. Kapasitas 10 pemain.',
            'is_active'     => true,
        ]);
    }
}
