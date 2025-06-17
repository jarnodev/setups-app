<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Simulator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first simulator (make sure it exists)
        $simulator = Simulator::first();

        // Check if there's at least one simulator
        if ($simulator)
        {
            // Create an array of all car names
            $carNames = [
                'Aston Martin V12 Vantage GT3',
                'AMR V8 Vantage GT3',
                'Audi R8 LMS GT3',
                'Audi R8 LMS EVO GT3',
                'Audi R8 LMS EVO II GT3',
                'Bentley Continental GT3 2015',
                'Bentley Continental GT3 2018',
                'BMW M6 GT3',
                'BMW M4 GT3',
                'Emil Frey Jaguar G3',
                'Ferrari 296 GT3',
                'Ferrari 488 GT3',
                'Ferrari 488 EVO GT3',
                'Honda NSX GT3',
                'Honda NSX Evo GT3',
                'Lamborghini Huracán GT3',
                'Lamborghini Huracán Evo GT3',
                'Lamborghini Huracán GT3 Evo2',
                'Lexus RC F GT3',
                'McLaren 650S GT3',
                'McLaren 720S GT3',
                'McLaren 720S GT3 Evo',
                'Mercedes AMG GT3',
                'Mercedes AMG EVO GT3',
                'Nissan GTR NISMO GT3 2015',
                'Nissan GTR NISMO GT3 2018',
                'Porsche 911 GT3R',
                'Porsche 911 II GT3R',
                'Porsche 911 GT3 R (992)',
                'Reiter Engineering R-EX GT3',
                'Alpine A110',
                'AMR V8 Vantage',
                'Audi R8 LMS',
                'BMW M4',
                'Chevrolet Camaro R',
                'Ginetta G55',
                'KTM X-BOW',
                'Maserati GranTurismo MC',
                'McLaren 570S',
                'Mercedes AMG',
                'Porsche 718 Cayman GT4Clubsport',
                'Lamborghini Huracán SuperTrofeo',
                'Lamborghini Huracán SuperTrofeo EVO2',
                'Porsche 911 II GT3 Cup',
                'Porsche 911 GT3 Cup (992)',
                'Ferrari 488 Challenge Evo',
                'BMW M2 CS Racing',
                'Ferrari 488 GT3 EVO 2020',
                'Mercedes-AMG GT3 EVO (2020)',
                'Alpine A110',
                'AMR V8 Vantage',
                'Audi R8 LMS',
                'BMW M4',
                'Chevrolet Camaro R',
                'Ginetta G55',
                'KTM X-BOW',
                'Maserati GranTurismo MC',
                'McLaren 570S',
                'Mercedes AMG',
                'Porsche 718 Cayman GT4Clubsport',
                'Audi R8 LMS EVO II GT3',
                'BMW M2 CS Racing',
                'Ferrari 488 Challenge Evo',
                'Lamborghini Huracán SuperTrofeo EVO2',
                'Porsche 911 GT3 Cup (992)',
                'Ferrari 296 GT3',
                'Lamborghini Huracán GT3 Evo2',
                'Porsche 911 GT3 R (992)',
            ];

            // Insert cars into the database
            $cars = Car::insert(array_map(function ($name)
            {
                return ['name' => $name];
            }, $carNames));

            // Now that cars are created, we can associate them with the simulator
            // Attach all the cars to the first simulator using the pivot table
            $simulator->cars()->attach(Car::all()->pluck('id')->toArray());
        }
        else
        {
            // If no simulators exist, show a warning
            echo "No simulators found in the database.";
        }
    }
}
