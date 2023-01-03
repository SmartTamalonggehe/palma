<?php

namespace Database\Factories;

use App\Models\Distrik;
use App\Models\Pelapor;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrangHilangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $pelapor_id = Pelapor::all()->random()->id;
        return [
            'pelapor_id' => $pelapor_id,
            'nama' => $this->faker->name(),
            'umur' => $this->faker->numberBetween(10, 80),
            'no_ktp' => $this->faker->numerify(),
            'no_kk' => $this->faker->numerify(),
            'no_hp' => $this->faker->numerify(),
            'suku' => $this->faker->randomElement(['merah', 'kuning', 'hijau', 'biru', 'ungu', 'hitam', 'putih']),
            'tinggi' => $this->faker->numberBetween(10, 80),
            'berat' => $this->faker->numberBetween(10, 80),
            'warna_rambut' => $this->faker->randomElement(['merah', 'kuning', 'hijau', 'biru', 'ungu', 'hitam', 'putih']),
            'jenis_rambut' => $this->faker->randomElement(['merah', 'kuning', 'hijau', 'biru', 'ungu', 'hitam', 'putih']),
            'warna_kulit' => $this->faker->randomElement(['hitam', 'putih']),
            'pakaian_terakhir' => $this->faker->randomElement(['merah', 'kuning', 'hijau', 'biru', 'ungu', 'hitam', 'putih']),
            'foto' => $this->faker->imageUrl(640, 480, 'animals', true),
            'hubungan' => $this->faker->randomElement(['adik', 'kakak', 'anak', 'mama', 'bapak']),
            'alamat' => $this->faker->address(),
            'status' => $this->faker->randomElement(['diproses', 'ditolak']),
        ];
    }
}
