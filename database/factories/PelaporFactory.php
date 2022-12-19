<?php

namespace Database\Factories;

use App\Models\Distrik;
use Illuminate\Database\Eloquent\Factories\Factory;

class PelaporFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $distrik_id = Distrik::all()->random()->id;
        return [
            'distrik_id' => $distrik_id,
            'nama' => $this->faker->name(),
            'no_ktp' => $this->faker->numerify(),
            'no_kk' => $this->faker->numerify(),
            'no_hp' => $this->faker->numerify(),
            'alamat' => $this->faker->address(),
            'foto_ktp' => $this->faker->imageUrl(640, 480, 'animals', true),
            'foto_kk' => $this->faker->imageUrl(640, 480, 'animals', true),
            'status' => $this->faker->randomElement(['proses', 'terima', 'tolak']),
        ];
    }
}
