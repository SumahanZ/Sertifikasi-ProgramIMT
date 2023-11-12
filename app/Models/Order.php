<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function customer() {
        return $this->belongsTo(Customer::class, "customer_id", "id");
    }

    public function vehicles() {
        return $this->belongsToMany(Vehicle::class,"order_vehicle", "order_id", "vehicle_id")->withPivot('jumlah_kendaraan_dipesan');
    }
}
