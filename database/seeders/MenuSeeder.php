<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    // contoh membuat 1 data menu
    Menu::factory()->count(1)->create();
}
}
