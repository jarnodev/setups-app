<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSetupRequest;
use App\Models\Car;
use App\Models\Setup;
use App\Models\Simulator;
use App\Models\Track;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Illuminate\Support\Str;

class SetupController extends Controller
{
    public function index()
    {
        $setups = Cache::remember(
            'user.setups',
            900,
            function ()
            {
                return Setup::where('user_id', Auth::user()->id)->with(['user', 'simulator', 'track', 'car'])->get();
            }
        );

        return Inertia::render('dashboard/Setups/Index', [
            'setups' => $setups,
            'user' => Auth::user()
        ]);
    }

    public function create()
    {
        // We'll do a rememberForever as these don't change too often
        // And it can be called a lot of times if users are active in the dashboard.
        // TODO: Observer to check if a new sim/track/car has been added or modified
        // then invalidate and recache.
        $simulators = Cache::rememberForever('simulators', fn() => Simulator::all());
        $tracks = Cache::rememberForever('tracks', fn() => Track::all());
        $cars = Cache::rememberForever('cars', fn() => Car::all());

        return Inertia::render('dashboard/Setups/Create', [
            'simulators' => $simulators,
            'tracks' => $tracks,
            'cars' => $cars,
        ]);
    }

    public function view(Setup $setup)
    {
        return Inertia::render('dashboard/Setups/View', [
            'setup' => $setup,
        ]);
    }

    public function store(StoreSetupRequest $storeSetupRequest)
    {
        $validated = $storeSetupRequest->validated();

        Setup::create([
            'user_id' => 1,
            'uuid' => Str::uuid(),
            'simulator_id' => $validated['simulator_id'],
            'track_id' => $validated['track_id'],
            'car_id' => $validated['car_id'],
            'lap_time_ms' => $validated['lap_time_ms'],
            'lap_time_recorded_at' => $validated['lap_time_recorded_at'],
            'setup_type' => $validated['setup_type'],
            'setup_data' => $validated['setup_data']->get(),
            'is_public' => $validated['is_public'] ?? false,
        ]);

        return redirect()->route('dashboard.setups.index');
    }
}
