<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setup extends Model
{
    protected $primaryKey = 'uuid';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'uuid',
        'simulator_id',
        'track_id',
        'car_id',
        'lap_time_ms',
        'lap_time_recorded_at',
        'setup_type',
        'setup_data',
        'is_public',
    ];

    protected $with = [
        'user',
        'simulator',
        'track',
        'car'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function simulator()
    {
        return $this->belongsTo(Simulator::class);
    }

    public function track()
    {
        return $this->belongsTo(Track::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
