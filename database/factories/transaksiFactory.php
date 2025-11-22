<?php

namespace Database\Factories;

use App\Models\Transaksi;
use App\Models\Users;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaksi>
 */
class transaksiFactory extends Factory
{
    protected $model = Transaksi::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ambil hanya user dengan role kasir (roles_id = 2)
        // Jika ada lebih dari 1 kasir, akan dipilih secara random
        $kasir = Users::where('roles_id', 2)->inRandomOrder()->first();

        // Diskon random 0-20%
        $diskon = $this->faker->randomFloat(2, 0, 50000);

        return [
            'user_id' => $kasir?->id ?? Users::factory()->create(['roles_id' => 2])->id,
            'invoice' => 'INV-' . strtoupper($this->faker->unique()->bothify('??###??###')),
            'nama_customer' => $this->faker->optional(0.7)->name(), // 70% ada nama customer
            'catatan' => $this->faker->optional(0.3)->sentence(), // 30% ada catatan
            'total' => 0, // akan dihitung dari detail
            'diskon' => $diskon,
            'bayar' => 0, // akan dihitung setelah total diketahui
            'kembali' => 0, // akan dihitung setelah bayar
            'metode_pembayaran' => $this->faker->randomElement(['cash', 'qris']),
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
