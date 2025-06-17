<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Simulator extends Model
{
    protected $fillable = [
        'name',
    ];

    public function tracks()
    {
        return $this->belongsToMany(Track::class, 'simulator_tracks');
    }

    public function cars()
    {
        return $this->belongsToMany(Car::class, 'simulator_cars');
    }
}
