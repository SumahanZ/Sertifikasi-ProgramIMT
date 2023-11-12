<?php

use App\Models\Car;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\CustomerController;

Route::get('/', function () {
    return redirect("/customers");
});

Route::get("/customers", [CustomerController::class, "index"]);
Route::get("/customer-add", [CustomerController::class, "create"]);
Route::post('/customer', [CustomerController::class, "store"]);
Route::get("/customer-edit/{id}", [CustomerController::class, "edit"]);
Route::put("/customer/{id}", [CustomerController::class, "update"]);
Route::get("/customer-delete/{id}", [CustomerController::class, "delete"]);
Route::delete("/customer-destroy/{id}", [CustomerController::class, "destroy"]);

Route::get("/orders", [OrderController::class, "index"]);
Route::get("/order-add", [OrderController::class, "create"]);
Route::post('/order', [OrderController::class, "store"]);
Route::get("/order-edit/{id}", [OrderController::class, "edit"]);
Route::put("/order/{id}", [OrderController::class, "update"]);
Route::get("/order-delete/{id}", [OrderController::class, "delete"]);
Route::delete("/order-destroy/{id}", [OrderController::class, "destroy"]);

Route::get("/vehicles", [VehicleController::class, "index"]);
Route::get("/vehicle-add", [VehicleController::class, "create"]);
Route::post('/vehicle', [VehicleController::class, "store"]);
Route::get("/vehicle-edit/{id}", [VehicleController::class, "edit"]);
Route::get("/vehicle-detail/{id}", [VehicleController::class, "show"]);
Route::put("/vehicle/{id}", [VehicleController::class, "update"]);
Route::get("/vehicle-delete/{id}", [VehicleController::class, "delete"]);
Route::delete("/vehicle-destroy/{id}", [VehicleController::class, "destroy"]);