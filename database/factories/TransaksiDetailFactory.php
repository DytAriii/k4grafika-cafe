<?php

namespace Database\Factories;

use App\Models\TransaksiDetail;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransaksiDetail>
 */
class TransaksiDetailFactory extends Factory
{
    protected $model = TransaksiDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $menu = Menu::inRandomOrder()->first();
        $jumlah = $this->faker->numberBetween(1, 5);
        $harga = $menu->harga;
        $subtotal = $harga * $jumlah;

        return [
            'menu_id' => $menu->id,
            'jumlah' => $jumlah,
            'harga' => $harga,
            'subtotal' => $subtotal,
        ];
    }
}
