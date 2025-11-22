<?php

namespace Database\Seeders;

use App\Models\Users;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KasirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat beberapa kasir tambahan
        // roles_id = 2 adalah kasir
        
        Users::updateOrCreate(
            ['username' => 'kasir1'],
            [
                'password' => bcrypt('kasir123'),
                'roles_id' => 2,
            ]
        );

        Users::updateOrCreate(
            ['username' => 'kasir2'],
            [
                'password' => bcrypt('kasir123'),
                'roles_id' => 2,
            ]
        );

        Users::updateOrCreate(
            ['username' => 'kasir3'],
            [
                'password' => bcrypt('kasir123'),
                'roles_id' => 2,
            ]
        );
    }
}
