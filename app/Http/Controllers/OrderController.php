<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Vehicle;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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
    {        $vehicles = Vehicle::get();
        return view("order-add", ["vehicleList" => $vehicles]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telp' => 'required|numeric',
            'id_card' => 'required|string|max:255',
            'jumlah_kendaraan' => 'required|integer|min:1|max:5',
        ]);
    
        if ($validator->fails()) {
            return redirect('/order-add')
                ->withErrors($validator)
                ->withInput();
        }

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

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telp' => 'required|numeric',
            'id_card' => 'required|string|max:255',
            'jumlah_kendaraan' => 'required|integer|min:1|max:5',
        ]);
    
        if ($validator->fails()) {
            return redirect("order-edit/$id")
                ->withErrors($validator)
                ->withInput();
        }

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
