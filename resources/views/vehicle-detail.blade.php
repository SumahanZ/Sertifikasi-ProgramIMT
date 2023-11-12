@extends("layouts.mainlayout")

@section("title", "Detail Vehicle")

@section("content")
<div class="container d-flex align-items-center justify-content-center vh-100">
    <div class="card shadow-lg" style="width: 30rem;">
        <img src="{{ asset('storage/vehicle_images/'.$vehicleInfo->vehicle->image)}}" alt="{{ $vehicleInfo->vehicle->model }}" class="card-img-top rounded-top">
        <div class="card-body">
            <h2 class="card-title text-center">Model: {{ $vehicleInfo->vehicle->model }}</h2>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Tahun:</strong> {{ $vehicleInfo->vehicle->tahun }}</li>
                <li class="list-group-item"><strong>Jumlah Penumpang:</strong> {{ $vehicleInfo->vehicle->jumlah_penumpang }}</li>
                <li class="list-group-item"><strong>Manufaktur:</strong> {{ $vehicleInfo->vehicle->manufaktur }}</li>
                <li class="list-group-item"><strong>Harga:</strong> Rp{{ number_format($vehicleInfo->vehicle->harga, 2) }}</li>

                @if ($vehicleInfo->vehicle->vehicleable_type == "App\Models\Car")
                    <li class="list-group-item"><strong>Tipe Kendaraan:</strong> Car</li>
                    <li class="list-group-item"><strong>Tipe Bahan Bakar:</strong> {{ $vehicleInfo->tipe_bahan_bakar }}</li>
                    <li class="list-group-item"><strong>Luas Bagasi:</strong> {{ $vehicleInfo->luas_bagasi }}</li>
                @elseif ($vehicleInfo->vehicle->vehicleable_type == "App\Models\Truck")
                    <li class="list-group-item"><strong>Tipe Kendaraan:</strong> Truck</li>
                    <li class="list-group-item"><strong>Jumlah Roda Ban:</strong> {{ $vehicleInfo->jumlah_roda_ban }}</li>
                    <li class="list-group-item"><strong>Luas Area Kargo:</strong> {{ $vehicleInfo->luas_area_kargo }}</li>
                @else
                    <li class="list-group-item"><strong>Tipe Kendaraan:</strong> Motor Bike</li>
                    <li class="list-group-item"><strong>Ukuran Bagasi:</strong> {{ $vehicleInfo->ukuran_bagasi }}</li>
                    <li class="list-group-item"><strong>Kapasitas Bensin:</strong> {{ $vehicleInfo->kapasitas_bensin }}</li>
                @endif
            </ul>
        </div>
    </div>
</div>
@endsection
