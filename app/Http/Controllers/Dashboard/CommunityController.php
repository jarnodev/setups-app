<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setup;
use Inertia\Inertia;

class CommunityController extends Controller
{
    public function index()
    {
        $setups = Setup::where('is_public', boolean: true);

        return Inertia::render('dashboard/Community', [
            'setups' => $setups
        ]);
    }
}
