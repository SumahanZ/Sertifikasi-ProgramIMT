@extends("layouts.mainlayout")

@section("title", "Edit Vehicle")

@section("content")
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Edit Vehicle</h2>

                <form action="/vehicle/{{ $vehicle->id }}" method="POST" id="vehicleForm" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="mb-3">
                        <label for="model" class="form-label">Model</label>
                        <input type="text" class="form-control" id="model" name="model" value="{{ $vehicle->model }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <input type="text" class="form-control" id="tahun" name="tahun" value="{{ $vehicle->tahun }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="jumlah_penumpang" class="form-label">Jumlah Penumpang</label>
                        <input type="tel" class="form-control" id="jumlah_penumpang" name="jumlah_penumpang" value="{{ $vehicle->jumlah_penumpang }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="manufaktur" class="form-label">Manufaktur</label>
                        <input type="text" class="form-control" id="manufaktur" name="manufaktur" value="{{ $vehicle->manufaktur }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="text" class="form-control" id="harga" name="harga" value="{{ $vehicle->harga }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="photo" class="form-label">Image</label>
                        <div class="input-group">
                            <label for="photo" class="form-control" id="photoLabel" style="cursor: pointer;">{{ $vehicle->image ? $vehicle->image : 'Choose a file' }}</label>
                            <input type="file" class="d-none" id="photo" name="photo">
                        </div>
                    </div>
                    
                    <div class="mb-3 mt-3">
                        <label for="type" class="form-label">Vehicle Type</label>
                        <select class="form-control" id="type" name="type" required onchange="toggleFields()">
                            <option value="" {{ $vehicle->vehicleable_type ? '' : 'selected' }}>Select One</option>
                            <option value="car" {{ $vehicle->vehicleable_type == 'App\Models\Car' ? 'selected' : '' }}>Car</option>
                            <option value="truck" {{ $vehicle->vehicleable_type == 'App\Models\Truck' ? 'selected' : '' }}>Truck</option>
                            <option value="motorbike" {{ $vehicle->vehicleable_type == 'App\Models\MotorBike' ? 'selected' : '' }}>Motorbike</option>
                        </select>
                        
                    </div>

                    <div id="additionalFields" style="display: none;">
                    </div>

                    <div class="d-grid gap-5 mt-3">
                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateImageText() {
        var photoInput = document.getElementById("photo");
        var photoLabel = document.getElementById("photoLabel");

        photoInput.addEventListener("change", function() {
            var fileName = this.value.split("\\").pop();
            photoLabel.textContent = fileName ? fileName : '{{ $vehicle->image ? $vehicle->image : "Choose a file" }}';
        });
    }

        function toggleFields() {
            var type = document.getElementById("type").value;
            var additionalFields = document.getElementById("additionalFields");

            additionalFields.innerHTML = "";
            additionalFields.style.display = "none";

            switch (type) {
                case "car":
                    addTextField("Tipe Bahan Bakar", "tipe_bahan_bakar", "{{ $vehicles ? $vehicles->tipe_bahan_bakar : '' }}");
                    addTextField("Luas Bagasi", "luas_bagasi", "{{ $vehicles ? $vehicles->luas_bagasi : '' }}");
                    break;
                case "truck":
                    addTextField("Jumlah Roda", "jumlah_roda", "{{ $vehicles ? $vehicles->jumlah_roda_ban : '' }}");
                    addTextField("Area Kargo", "area_kargo", "{{ $vehicles ? $vehicles->luas_area_kargo : '' }}");
                    break;
                case "motorbike":
                    addTextField("Ukuran Bagasi", "ukuran_bagasi", "{{ $vehicles ? $vehicles->ukuran_bagasi : '' }}");
                    addTextField("Kapasitas Bensin", "kapasitas_bensin", "{{ $vehicles ? $vehicles->kapasitas_bensin : '' }}");
                    break;
                default:
                    break;
            }

            if (additionalFields.children.length > 0) {
                additionalFields.style.display = "block";
            }
        }


        function addTextField(label, name, prevalue) {
            var div = document.createElement("div");
            div.className = "mb-3";
            
            var labelElement = document.createElement("label");
            labelElement.setAttribute("for", name);
            labelElement.className = "form-label";
            labelElement.textContent = label;

            var inputElement = document.createElement("input");
            inputElement.type = "text";
            inputElement.className = "form-control";
            inputElement.id = name;
            inputElement.name = name;
            inputElement.value = prevalue; 

            div.appendChild(labelElement);
            div.appendChild(inputElement);

            additionalFields.appendChild(div);
        }

        toggleFields();
        updateImagePreview();
    </script>
@endsection
