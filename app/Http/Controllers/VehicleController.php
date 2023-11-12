<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\MotorBike;
use App\Models\Truck;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;

class VehicleController extends Controller
{
    public function index()
    {
        $trucks = Truck::with("vehicle")->get();
        $cars = Car::with("vehicle")->get();
        $motorbikes = MotorBike::with("vehicle")->get();

        return view("vehicle", [
                "truckList" => $trucks,
                "carList" => $cars,
                "motorBikeList" => $motorbikes,
        ]);
    }

    public function create()
    {
        return view("vehicle-add");
    }

    public function edit(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $vehicles = [];

        if ($vehicle->vehicleable_type == "App\Models\Car") {
            $vehicles = Car::findOrFail($vehicle->vehicleable_id);
        } else if ($vehicle->vehicleable_type == "App\Models\Truck") {
            $vehicles = Truck::findOrFail($vehicle->vehicleable_id);
        } else {
            $vehicles = MotorBike::findOrFail($vehicle->vehicleable_id);
        }
        return view("vehicle-edit", ["vehicle" => $vehicle, "vehicles" => $vehicles]);
    }

    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $newName = $vehicle->image;
    
        if ($request->file("photo")) {
            $extension = $request->file('photo')->getClientOriginalExtension();
            $newName = $request->model . "-" . now()->timestamp . "." . $extension;
            $request->file("photo")->storeAs("vehicle_images", $newName);
        }
    
        if ($request->type == "car") {
            $car = Car::findOrFail($vehicle->vehicleable_id);
            $car->tipe_bahan_bakar = $request->tipe_bahan_bakar;
            $car->luas_bagasi = $request->luas_bagasi;
            $car->save();
    
            if ($newName != $vehicle->image) {
                $vehicle->image = $newName;
            }
    
            $vehicle->update([
                "model" => $request->model,
                "tahun" => $request->tahun,
                "jumlah_penumpang" => $request->jumlah_penumpang,
                "manufaktur" => $request->manufaktur,
                "harga" => $request->harga,
                "vehicleable_id" => $car->id,
                "vehicleable_type" => "App\Models\Car",
            ]);
    
            if ($car) {
                Session::flash("status", "success");
                Session::flash("message", "Update vehicle success!");
            }
    
        } elseif ($request->type == "truck") {
            $truck = Truck::findOrFail($vehicle->vehicleable_id);
            $truck->jumlah_roda_ban = $request->jumlah_roda;
            $truck->luas_area_kargo = $request->area_kargo;
            $truck->save();
    
            // Check if the new image is different from the current one
            if ($newName != $vehicle->image) {
                $vehicle->image = $newName;
            }
    
            $vehicle->update([
                "model" => $request->model,
                "tahun" => $request->tahun,
                "jumlah_penumpang" => $request->jumlah_penumpang,
                "manufaktur" => $request->manufaktur,
                "harga" => $request->harga,
                "vehicleable_id" => $truck->id,
                "vehicleable_type" => "App\Models\Truck",
            ]);
    
            if ($truck) {
                Session::flash("status", "success");
                Session::flash("message", "Update vehicle success!");
            }
        } else {
            $bike = MotorBike::findOrFail($vehicle->vehicleable_id);
            $bike->ukuran_bagasi = $request->ukuran_bagasi;
            $bike->kapasitas_bensin = $request->kapasitas_bensin;
            $bike->save();
    
            if ($newName !== $vehicle->image) {
                $vehicle->image = $newName;
            }
    
            $vehicle->update([
                "model" => $request->model,
                "tahun" => $request->tahun,
                "jumlah_penumpang" => $request->jumlah_penumpang,
                "manufaktur" => $request->manufaktur,
                "harga" => $request->harga,
                "vehicleable_id" => $bike->id,
                "vehicleable_type" => "App\Models\MotorBike",
            ]);
    
            if ($bike) {
                Session::flash("status", "success");
                Session::flash("message", "Update vehicle success!");
            }
        }
        return redirect("/vehicles");
    }
    

    public function store(Request $request)
    {
        $newName = "";

        if ($request->file("photo")) {
            $extension = $request->file('photo')->getClientOriginalExtension();
            $newName = $request->model . "-" . now()->timestamp . "." . $extension;
            $request->file("photo")->storeAs("vehicle_images", $newName);
        }

        $this->createSpecificVehicleRecord($request, $newName);
        return redirect("/vehicles");
    }

    public function show($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $vehicles = [];

        if ($vehicle->vehicleable_type == "App\Models\Car") {
            $vehicles = Car::findOrFail($vehicle->vehicleable_id)->with(["vehicle"])->first();
        } else if ($vehicle->vehicleable_type == "App\Models\Truck") {
            $vehicles = Truck::findOrFail($vehicle->vehicleable_id)->with(["vehicle"])->first();
        } else {
            $vehicles = MotorBike::findOrFail($vehicle->vehicleable_id)->with(["vehicle"])->first();
        }

        return view('vehicle-detail', [
            "vehicleInfo" => $vehicles,
        ]);
    }

    private function createSpecificVehicleRecord(Request $request, String $newName)
    {
        if ($request->type == "car") {
            $car = new Car;
            $car->tipe_bahan_bakar = $request->tipe_bahan_bakar;
            $car->luas_bagasi = $request->luas_bagasi;
            $car->save();

            Vehicle::create([
                "model" => $request->model,
                "tahun" => $request->tahun,
                "jumlah_penumpang" => $request->jumlah_penumpang,
                "manufaktur" => $request->manufaktur,
                "harga" => $request->harga,
                "image" => $newName,
                "vehicleable_id" => $car->id,
                "vehicleable_type" => "App\Models\Car",
            ]);

            if ($car) {
                Session::flash("status", "success");
                Session::flash("message", "Edit vehicle success!");
            }
        } else if ($request->type == "truck") {
            $truck = new Truck;
            $truck->jumlah_roda_ban = $request->jumlah_roda;
            $truck->luas_area_kargo = $request->area_kargo;
            $truck->save();

            Vehicle::create([
                "model" => $request->model,
                "tahun" => $request->tahun,
                "jumlah_penumpang" => $request->jumlah_penumpang,
                "manufaktur" => $request->manufaktur,
                "harga" => $request->harga,
                "image" => $newName,
                "vehicleable_id" => $truck->id,
                "vehicleable_type" => "App\Models\Truck",
            ]);

            if ($truck) {
                Session::flash("status", "success");
                Session::flash("message", "Edit vehicle success!");
            }
        } else {
            $bike = new MotorBike;
            $bike->ukuran_bagasi = $request->ukuran_bagasi;
            $bike->kapasitas_bensin = $request->kapasitas_bensin;
            $bike->save();

            Vehicle::create([
                "model" => $request->model,
                "tahun" => $request->tahun,
                "jumlah_penumpang" => $request->jumlah_penumpang,
                "manufaktur" => $request->manufaktur,
                "harga" => $request->harga,
                "image" => $newName,
                "vehicleable_id" => $bike->id,
                "vehicleable_type" => "App\Models\MotorBike",
            ]);

            if ($bike) {
                Session::flash("status", "success");
                Session::flash("message", "Edit vehicle success!");
            }
        }
    }

    public function delete($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return view("vehicle-delete", ["vehicle" => $vehicle]);
    }

    public function destroy($id)
    {
        $deleteVehicle = Vehicle::findOrFail($id);
        $deleteVehicle->delete();

        if ($deleteVehicle) {
            Session::flash("status", "success");
            Session::flash("message", "Delete vehicle success!");
        }

        return redirect("/vehicles");
    }

}
