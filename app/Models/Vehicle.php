<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function vehicleable() {
        return $this->morphTo();
    }

    public function orders() {
        return $this->belongsToMany(Order::class,"order_vehicle", "vehicle_id", "order_id")->withPivot('jumlah_kendaraan_dipesan');
    }
}
