<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotorBike extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table ="motorbikes";

    public function vehicle() {
        return $this->morphOne(Vehicle::class, 'vehicleable');
    }
}
