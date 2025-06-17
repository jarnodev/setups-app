<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class RaceEngineerController extends Controller
{
    public function index()
    {
        return Inertia::render('dashboard/RaceEngineer');
    }
}
