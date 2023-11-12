<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_vehicle', function (Blueprint $table) {
            $table->unsignedBigInteger("order_id");
            $table->foreign("order_id")->references('id')->on("orders")->onDelete("cascade");
            $table->unsignedBigInteger("vehicle_id");
            $table->foreign("vehicle_id")->references('id')->on("vehicles")->onDelete("cascade");
            $table->integer("jumlah_kendaraan_dipesan");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_vehicle');
    }
};
