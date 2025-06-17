<?php

namespace App\Http\Controllers\Dashboard;

use App\Agents\SetupEngineerAgent;
use App\Http\Controllers\Controller;
use App\Http\Requests\GenerateSetupRequest;
use App\Models\Car;
use App\Models\Simulator;
use App\Models\Track;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class RaceEngineerController extends Controller
{
    public function index()
    {
        // We'll do a rememberForever as these don't change too often
        // And it can be called a lot of times if users are active in the dashboard.
        // TODO: Observer to check if a new sim/track/car has been added or modified
        // then invalidate and recache.
        $simulators = Cache::rememberForever('simulators', fn() => Simulator::all());
        $tracks = Cache::rememberForever('tracks', fn() => Track::all());
        $cars = Cache::rememberForever('cars', fn() => Car::all());

        return Inertia::render('dashboard/RaceEngineer', [
            'simulators' => $simulators,
            'tracks' => $tracks,
            'cars' => $cars,
        ]);
    }

    public function generate(GenerateSetupRequest $generateSetupRequest)
    {
        $validated = $generateSetupRequest->validated();

        // Create an instance for a specific user or chat session
        $agent = SetupEngineerAgent::for(Auth::user()->id . time());

        // Get a response
        $response = $agent->respond($validated['setup_data']);

        return response()->json([
            'response' => $response
        ]);
    }
}
