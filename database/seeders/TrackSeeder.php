<?php

namespace Database\Seeders;

use App\Models\Simulator;
use App\Models\Track;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrackSeeder extends Seeder
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
            // Create an array of all track names
            $trackNames = [
                'Barcelona',
                'Brands Hatch',
                'Hungaroring',
                'Misano',
                'Monza',
                'Nürburgring',
                'Paul Ricard',
                'Silverstone',
                'Spa-Francochamps',
                'Zandvoort',
                'Zolder',
                'Snetterton',
                'Oulton Park',
                'Donington Park',
                'Kyalami Grand Prix Circuit',
                'Suzuka Circuit',
                'Weathertech Raceway Laguna Seca',
                'Mount Panorama Circuit',
                'Autodromo Internazionale Enzo e Dino Ferrari – Imola',
                'Watkins Glen',
                'Circuit of the Americas (COTA)',
                'Indianapolis',
                'Circuit Ricardo Tormo (Valencia)',
                'Red Bull Ring',
                '24H Nürburgring (Nordschleife)',
            ];

            // Insert tracks into the database
            $tracks = Track::insert(array_map(function ($name)
            {
                return ['name' => $name];
            }, $trackNames));

            // Now that tracks are created, we can associate them with the simulator
            // Attach all the tracks to the first simulator using the pivot table
            $simulator->tracks()->attach(Track::all()->pluck('id')->toArray());
        }
        else
        {
            // If no simulators exist, show a warning
            echo "No simulators found in the database.";
        }
    }
}
