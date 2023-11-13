<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\MotorBike;
use App\Models\Truck;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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

    $validator = Validator::make($request->all(), [
            'model' => 'required|string|max:255',
            'tahun' => 'required|string|max:4',
            'jumlah_penumpang' => 'required|numeric',
            'manufaktur' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|in:car,truck,motorbike',
            'tipe_bahan_bakar' => ($request->type == 'car') ? 'required|string|max:255' : '',
            'luas_bagasi' => ($request->type == 'car') ? 'required|string|max:255' : '',
            'jumlah_roda' => ($request->type == 'truck') ? 'required|numeric' : '',
            'area_kargo' => ($request->type == 'truck') ? 'required|string|max:255' : '',
            'ukuran_bagasi' => ($request->type == 'motorbike') ? 'required|string|max:255' : '',
            'kapasitas_bensin' => ($request->type == 'motorbike') ? 'required|numeric' : '',
        ]);
    
        if ($validator->fails()) {
            return redirect("/vehicle-edit/$id")
                ->withErrors($validator)
                ->withInput();
        }
    $vehicle = Vehicle::findOrFail($id);
    $newName = $vehicle->image;

    if ($request->file("photo")) {
        $extension = $request->file('photo')->getClientOriginalExtension();
        $newName = $request->model . "-" . now()->timestamp . "." . $extension;
        $request->file("photo")->storeAs("vehicle_images", $newName);
    }

    // Clear old type-specific attributes if the type has changed
    if ($request->type != $vehicle->vehicleable_type) {
        $vehicle->vehicleable()->delete();
    }

    if ($request->type == "car") {
        $car = Car::updateOrCreate(['id' => $vehicle->vehicleable_id], [
            'tipe_bahan_bakar' => $request->tipe_bahan_bakar,
            'luas_bagasi' => $request->luas_bagasi,
        ]);

        $vehicle->update([
            "model" => $request->model,
            "tahun" => $request->tahun,
            "jumlah_penumpang" => $request->jumlah_penumpang,
            "manufaktur" => $request->manufaktur,
            "harga" => $request->harga,
            "image" => $newName,
            "vehicleable_id" => $car->id,
            "vehicleable_type" => "App\Models\Car",
        ]);
    } elseif ($request->type == "truck") {
        $truck = Truck::updateOrCreate(['id' => $vehicle->vehicleable_id], [
            'jumlah_roda_ban' => $request->jumlah_roda,
            'luas_area_kargo' => $request->area_kargo,
        ]);

        $vehicle->update([
            "model" => $request->model,
            "tahun" => $request->tahun,
            "jumlah_penumpang" => $request->jumlah_penumpang,
            "manufaktur" => $request->manufaktur,
            "harga" => $request->harga,
            "image" => $newName,
            "vehicleable_id" => $truck->id,
            "vehicleable_type" => "App\Models\Truck",
        ]);
    } else {
        $bike = MotorBike::updateOrCreate(['id' => $vehicle->vehicleable_id], [
            'ukuran_bagasi' => $request->ukuran_bagasi,
            'kapasitas_bensin' => $request->kapasitas_bensin,
        ]);

        $vehicle->update([
            "model" => $request->model,
            "tahun" => $request->tahun,
            "jumlah_penumpang" => $request->jumlah_penumpang,
            "manufaktur" => $request->manufaktur,
            "harga" => $request->harga,
            "image" => $newName,
            "vehicleable_id" => $bike->id,
            "vehicleable_type" => "App\Models\MotorBike",
        ]);
    }

    Session::flash("status", "success");
    Session::flash("message", "Update vehicle success!");

    return redirect("/vehicles");
}

    

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'model' => 'required|string|max:255',
            'tahun' => 'required|string|max:4',
            'jumlah_penumpang' => 'required|numeric',
            'manufaktur' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|in:car,truck,motorbike',
            'tipe_bahan_bakar' => ($request->type == 'car') ? 'required|string|max:255' : '',
            'luas_bagasi' => ($request->type == 'car') ? 'required|string|max:255' : '',
            'jumlah_roda' => ($request->type == 'truck') ? 'required|numeric' : '',
            'area_kargo' => ($request->type == 'truck') ? 'required|string|max:255' : '',
            'ukuran_bagasi' => ($request->type == 'motorbike') ? 'required|string|max:255' : '',
            'kapasitas_bensin' => ($request->type == 'motorbike') ? 'required|numeric' : '',
        ]);
    
        if ($validator->fails()) {
            return redirect('/vehicle-add')
                ->withErrors($validator)
                ->withInput();
        }

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
                Session::flash("message", "Added vehicle success!");
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
