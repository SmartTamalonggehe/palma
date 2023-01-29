<?php

namespace Database\Seeders;

use App\Models\Distrik;
use Illuminate\Database\Seeder;

class DistrikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Distrik::create([
            'nama' => 'Jayapura Utara',
        ]);
        Distrik::create([
            'nama' => 'Jayapura Selatan',
        ]);
        Distrik::create([
            'nama' => 'Abepura',
        ]);
        Distrik::create([
            'nama' => 'Distrik Muara Tami',
        ]);
        Distrik::create([
            'nama' => 'Distrik Heram',
        ]);
    }
}
