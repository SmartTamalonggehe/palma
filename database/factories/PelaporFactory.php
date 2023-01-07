<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Distrik;
use Illuminate\Support\Facades\Hash;
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
        $user_id =  User::create([
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => Hash::make(12345678),
            'show_password' => 12345678,
            'role' => 'pelapor'
        ]);
        return [
            'distrik_id' => $distrik_id,
            'nama' => $user_id->name,
            'no_ktp' => $this->faker->numerify(),
            'no_kk' => $this->faker->numerify(),
            'no_hp' => $this->faker->numerify(),
            'alamat' => $this->faker->address(),
            'foto_ktp' => $this->faker->imageUrl(640, 480, 'animals', true),
            'foto_kk' => $this->faker->imageUrl(640, 480, 'animals', true),
            'status' => $this->faker->randomElement(['diproses', 'diterima', 'ditolak']),
            'user_id' => $user_id
        ];
    }
}
