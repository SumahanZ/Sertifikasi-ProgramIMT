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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string("model", 100)->unique();
            $table->integer("tahun");
            $table->integer("jumlah_penumpang");
            $table->string("manufaktur", 100);
            $table->bigInteger("harga");
            $table->integer("vehicleable_id");
            $table->string("vehicleable_type")->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
