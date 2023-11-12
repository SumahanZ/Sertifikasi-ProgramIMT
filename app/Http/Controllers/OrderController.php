<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(["customer", "vehicles"])->get();
        $totalPrices = [];

        foreach ($orders as $order) {
            $totalPrice = 0;

            foreach ($order->vehicles as $vehicle) {
                $totalPrice += ($vehicle->harga * $vehicle->pivot->jumlah_kendaraan_dipesan);
            }

            $totalPrices[$order->id] = $totalPrice;
        }

        return view("order", ["orderList" => $orders, "totalPrices" => $totalPrices]);
    }

    public function create()
    {
        $vehicles = Vehicle::get();
        return view("order-add", ["vehicleList" => $vehicles]);
    }

    public function store(Request $request)
    {

        $customer = Customer::create([
            "nama" => $request->nama,
            "alamat" => $request->alamat,
            "no_telp" => $request->no_telp,
            "id_card" => $request->id_card,
        ]);

        $order = new Order;
        $order->customer_id = $customer->id;
        $order->save();

        $vehicleCounts = array_count_values($request->selected_vehicles);

        foreach ($vehicleCounts as $specificName => $count) {
            $vehicle = Vehicle::where('model', $specificName)->first();
            $order->vehicles()->syncWithoutDetaching([$vehicle->id => [
                'jumlah_kendaraan_dipesan' => $count,
            ]]);
        }

        if ($order) {
            Session::flash("status", "success");
            Session::flash("message", "Add new order success!");
        }

        return redirect("/orders");
    }

    public function edit($id)
    {
        $vehicle = Vehicle::get();
        $order = Order::findOrFail($id);
        $vehiclesFromOrder = Order::with("vehicles")->findOrFail($id)->vehicles;
        return view("order-edit", ["order" => $order, "vehicleList" => $vehicle, "vehiclesFromOrder" => $vehiclesFromOrder]);
    }

    public function update(Request $request, $id)
    {
        $customerId = Order::findOrFail($id)->customer->id;

        Customer::findOrFail($customerId)->update([
            "nama" => $request->nama,
            "alamat" => $request->alamat,
            "no_telp" => $request->no_telp,
            "id_card" => $request->id_card,
        ]);

        $order = Order::findOrFail($id);
        $order->vehicles()->detach();

        $vehicleCounts = array_count_values($request->selected_vehicles);

        foreach ($vehicleCounts as $specificName => $count) {
            $vehicle = Vehicle::where('model', $specificName)->first();
            $order->vehicles()->attach($vehicle->id, [
                'jumlah_kendaraan_dipesan' => $count,
            ]);
        }

        if ($order) {
            Session::flash("status", "success");
            Session::flash("message", "Edit order success!");
        }

        return redirect("/orders");
    }

    public function delete($id)
    {   
        $order = Order::findOrFail($id);
        return view("order-delete", ["order" => $order]);
    }

    public function destroy($id)
    {   
        $deleteOrder = Order::findOrFail($id);
        $deleteOrder->delete();

        if($deleteOrder) {
            Session::flash("status", "success");
            Session::flash("message", "Delete order success!");
        }

        return redirect("/orders");
    }
}
