@extends("layouts.mainlayout")

@section("title", "Add Order")

@section("content")
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Add Order</h2>

                <form action="order" method="post">
                    @csrf

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="no_telp" class="form-label">No. Telepon</label>
                        <input type="tel" class="form-control" id="no_telp" name="no_telp" required>
                    </div>

                    <div class="mb-3">
                        <label for="id_card" class="form-label">ID Card</label>
                        <input type="text" class="form-control" id="id_card" name="id_card" required>
                    </div>

                    <div class="mb-3">
                        <label for="jumlah_kendaraan" class="form-label">Jumlah Kendaraan yang Ingin Dipesan</label>
                        <input type="range" class="form-range" id="jumlah_kendaraan" name="jumlah_kendaraan" min="1" max="5" step="1" required>
                        <output for="jumlah_kendaraan" id="jumlah_kendaraan_label">1</output>
                    </div>

                    <div id="vehicleSelectionContainer"></div>

                    <div class="d-grid gap-5 mt-5">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script> 
        document.getElementById('jumlah_kendaraan').addEventListener('input', function() {
            document.getElementById('jumlah_kendaraan_label').textContent = this.value;
            updateVehicleSelection();
        });

        function updateVehicleSelection() {
            var container = document.getElementById('vehicleSelectionContainer');
            container.innerHTML = '';
            var numberOfVehicles = document.getElementById('jumlah_kendaraan').value;

            for (var i = 0; i < numberOfVehicles; i++) {
                var vehicleDiv = document.createElement('div');
                vehicleDiv.innerHTML = '<label for="vehicle_' + i + '">Select Vehicle ' + (i + 1) + ':</label>' +
                    '<select class="form-select" id="vehicle_' + i + '" name="selected_vehicles[]">' +
                    '<option value="">Select...</option>' + 
                    @foreach ($vehicleList as $vehicle)
                        '<option value="{{ $vehicle->model }}">{{ $vehicle->model }} | {{ $vehicle->vehicleable_type == "App\Models\Car" ? "Car" : ($vehicle->vehicleable_type == "App\Models\Truck" ? "Truck" : "Motor Bike") }} | Rp. {{ $vehicle->harga }} </option>' +
                    @endforeach
                    '</select>';
                container.appendChild(vehicleDiv);
            }
        }
    </script>
@endsection
