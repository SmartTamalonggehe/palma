<?php

namespace Database\Factories;

use App\Models\OrangHilang;
use Illuminate\Database\Eloquent\Factories\Factory;

class LaporanFactory extends Factory
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
            'no_laporan' => $this->faker->uuid(),
            'tgl_laporan' => $this->faker->dateTimeBetween('-4 months', '-1 months'),
            'batas_pencarian' => $this->faker->dateTimeBetween('-1 months', '+5 months'),
        ];
    }
}
