<?php

namespace Database\Factories;

use App\Models\OrangHilang;
use Illuminate\Database\Eloquent\Factories\Factory;

class LokasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $orang_hilang_id = OrangHilang::all()->random()->id;
        return [
            'orang_hilang_id' => $orang_hilang_id,
            'longitude' => $this->faker->longitude($min = -180, $max = 180),
            'latitude' => $this->faker->latitude($min = -90, $max = 90),
        ];
    }
}
