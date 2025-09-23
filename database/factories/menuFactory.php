<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class menuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    // Main Course
    public function definition(): array
    {
        return [
            'nama' => "Ayam Geprek + Es Teh",
            'harga' => 12000,
            'categories_id' => 3,
            'gambar' => "geprekteh.png",
            'status_id' => 1,
        ];
    }

    public function ChickenKatsu(): self
    {
        return $this->state([
            'nama' => "Chicken Katsu",
            'harga' => 11000,
            'categories_id' => 3,
            'gambar' => "katsupitik.jpg",
            'status_id' => 1,
        ]);
    }

    public function ChickenSteak(): self
    {
        return $this->state([
            'nama' => "Chicken Steak",
            'harga' => 10000,
            'categories_id' => 3,
            'gambar' => "steakayam.png",
            'status_id' => 1,
        ]);
    }

    public function ChickenSteakTeh(): self
    {
        return $this->state([
            'nama' => "Chicken Steak + Es Teh",
            'harga' => 15000,
            'categories_id' => 3,
            'gambar' => "steakteh.png",
            'status_id' => 1,
        ]);
    }

    public function Indomie(): self
    {
        return $this->state([
            'nama' => "Indomie",
            'harga' => 7000,
            'categories_id' => 3,
            'gambar' => "indomie.png",
            'status_id' => 1,
        ]);
    }

    // Non Coffee
    public function IceStoned(): self
    {
        return $this->state([
            'nama' => "Ice Stoned",
            'harga' => 10000,
            'categories_id' => 2,
            'gambar' => "EsOyen.jpg",
            'status_id' => 1,
        ]);
    }
    
    public function LemonTea(): self
    {
        return $this->state([
            'nama' => "Lemon Tea",
            'harga' => 7000,
            'categories_id' => 2,
            'gambar' => "lemonTea.jpg",
            'status_id' => 1,
        ]);
    }

    public function CoconutIce(): self
    {
        return $this->state([
            'nama' => "Coconut Ice",
            'harga' => 7000,
            'categories_id' => 2,
            'gambar' => "degan.jpg",
            'status_id' => 1,
        ]);
    }

    public function CappuccinoCincau(): self
    {
        return $this->state([
            'nama' => "Cappuccino Cincau",
            'harga' => 6000,
            'categories_id' => 2,
            'gambar' => "capcin.webp",
            'status_id' => 1,
        ]);
    }

    public function MilkShake(): self
    {
        return $this->state([
            'nama' => "Milk Shake",
            'harga' => 7000,
            'categories_id' => 2,
            'gambar' => "milkshake.webp",
            'status_id' => 1,
        ]);
    }

    public function MilkTea(): self
    {
        return $this->state([
            'nama' => "Milk Tea",
            'harga' => 7000,
            'categories_id' => 2,
            'gambar' => "milkTea.jpg",
            'status_id' => 1,
        ]);
    }

    public function EsCemil(): self
    {
        return $this->state([
            'nama' => "Es Cemal Cemil",
            'harga' => 7000,
            'categories_id' => 2,
            'gambar' => "escemil.jpeg",
            'status_id' => 1,
        ]);
    }

    public function Juice (): self
    {
        return $this->state([
            'nama' => "Juice",
            'harga' => 7000,
            'categories_id' => 2,
            'gambar' => "jus.jpeg",
            'status_id' => 1,
        ]);
    }   

    public function TehPoci (): self
    {
        return $this->state([
            'nama' => "Teh Poci",
            'harga' => 6000,
            'categories_id' => 2,
            'gambar' => "tehpoci.jpg",
            'status_id' => 1,
        ]);
    }

    //Coffee
    public function BlackCoffee(): self
    {
        return $this->state([
            'nama' => "Black Coffee",
            'harga' => 7000,
            'categories_id' => 1,
            'gambar' => "blackcoffee.webp",
            'status_id' => 1,
        ]);
    }

    public function CreamerCoffee(): self
    {
        return $this->state([
            'nama' => "Creamer Coffee",
            'harga' => 15000,
            'categories_id' => 1,
            'gambar' => "kopicreamer.jpg",
            'status_id' => 1,
        ]);
    }

    public function ColdBrew(): self
    {
        return $this->state([
            'nama' => "Cold Brew Coffee",
            'harga' => 12000,
            'categories_id' => 1,
            'gambar' => "coldbrew.jpg",
            'status_id' => 1,
        ]);
    }

    public function Americano(): self
    {
        return $this->state([
            'nama' => "Americano Coffee",
            'harga' => 15000,
            'categories_id' => 1,
            'gambar' => "americano.jpg",
            'status_id' => 1,
        ]);
    }

    //Snack
    public function Jasuke(): self
    {
        return $this->state([
            'nama' => "jasuke",
            'harga' => 10000,
            'categories_id' => 4,
            'gambar' => "jasuke.jpg",
            'status_id' => 1,
        ]);
    }

    public function TahuWalik(): self
    {
        return $this->state([
            'nama' => "Tahu Walik",
            'harga' => 10000,
            'categories_id' => 4,
            'gambar' => "tahuwalik.jpg",
            'status_id' => 1,
        ]);
    }

    public function TahuBakso(): self
    {
        return $this->state([
            'nama' => "Tahu Bakso",
            'harga' => 10000,
            'categories_id' => 4,
            'gambar' => "tahubakso.jpg",
            'status_id' => 1,
        ]);
    }

    public function Donat(): self
    {
        return $this->state([
            'nama' => "Donat",
            'harga' => 8000,
            'categories_id' => 4,
            'gambar' => "donat.webp",
            'status_id' => 1,
        ]);
    }
}