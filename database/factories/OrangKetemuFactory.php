<?php

namespace Database\Factories;

use App\Models\OrangHilang;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrangKetemuFactory extends Factory
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
            'alamat_ketemu' => $this->faker->address(),
            'nm_penemu' => $this->faker->name(),
        ];
    }
}
