<?php

namespace Database\Seeders;

use App\Models\Simulator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SimulatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Simulator::insert(
            [
                'name' => 'Assetto Corsa Competizione'
            ],
            [
                'name' => 'Le Mans Ultimate'
            ]
        );
    }
}
