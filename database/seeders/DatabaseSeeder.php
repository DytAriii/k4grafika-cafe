<?php

namespace Database\Seeders;

use App\Models\users;
use App\Models\roles;
use App\Models\Category;
use App\Models\Menu;
use App\Models\status;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // seed roles
        roles::factory()->create();
        roles::factory()->kasir()->create();

        // seed status
        status::factory()->create();
        status::factory()->unavailable()->create();

        // seed users dengan aman (tidak duplikat)
        users::updateOrCreate(
            ['username' => 'admin'],
            [
                'password' => bcrypt('admin123'),
                'roles_id' => 1,
            ]
        );

        users::updateOrCreate(
            ['username' => 'kasir'],
            [
                'password' => bcrypt('kasir123'),
                'roles_id' => 2,
            ]
        );

        // seed categories
        Category::factory()->create();
        Category::factory()->NonCoffee()->create();
        Category::factory()->MainCourse()->create();
        Category::factory()->Snack()->create();

        //Main Course
        Menu::factory()->create();
        Menu::factory()->ChickenKatsu()->create();
        Menu::factory()->ChickenSteak()->create();
        Menu::factory()->ChickenSteakTeh()->create();
        Menu::factory()->Indomie()->create();

        //Non Coffee
        Menu::factory()->IceStoned()->create();
        Menu::factory()->LemonTea()->create();
        Menu::factory()->CoconutIce()->create();
        Menu::factory()->CappuccinoCincau()->create();
        Menu::factory()->MilkShake()->create();
        Menu::factory()->MilkTea()->create();
        Menu::factory()->EsCemil()->create();
        Menu::factory()->Juice()->create();
        Menu::factory()->TehPoci()->create();

        //Coffee
        Menu::factory()->BlackCoffee()->create();
        Menu::factory()->CreamerCoffee()->create();
        Menu::factory()->ColdBrew()->create();
        Menu::factory()->Americano()->create();

        //Snack
        Menu::factory()->Jasuke()->create();
        Menu::factory()->TahuWalik()->create();
        Menu::factory()->TahuBakso()->create();
        Menu::factory()->Donat()->create();

        // Seed kasir tambahan (opsional, jika ingin lebih dari 1 kasir)
        $this->call(KasirSeeder::class);
    }

}
