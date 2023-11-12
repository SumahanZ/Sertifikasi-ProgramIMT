@extends("layouts.mainlayout")

@section("title", "Add Vehicle")

@section("content")
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Add Vehicle</h2>

                <form action="vehicle" method="post" id="vehicleForm" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="model" class="form-label">Model</label>
                        <input type="text" class="form-control" id="model" name="model" required>
                    </div>

                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <input type="text" class="form-control" id="tahun" name="tahun" required>
                    </div>

                    <div class="mb-3">
                        <label for="jumlah_penumpang" class="form-label">Jumlah Penumpang</label>
                        <input type="tel" class="form-control" id="jumlah_penumpang" name="jumlah_penumpang" required>
                    </div>

                    <div class="mb-3">
                        <label for="manufaktur" class="form-label">Manufaktur</label>
                        <input type="text" class="form-control" id="manufaktur" name="manufaktur" required>
                    </div>

                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="text" class="form-control" id="harga" name="harga" required>
                    </div>

                    <div class="mb-3">
                        <label for="photo" class="form-label">Image</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="photo" name="photo">
                        </div>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="type" class="form-label">Vehicle Type</label>
                        <select class="form-control" id="type" name="type" required onchange="toggleFields()">
                            <option value="">Select One</option>
                            <option value="car">Car</option>
                            <option value="truck">Truck</option>
                            <option value="motorbike">Motorbike</option>
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
        function toggleFields() {
            var type = document.getElementById("type").value;
            var additionalFields = document.getElementById("additionalFields");

            additionalFields.innerHTML = "";
            additionalFields.style.display = "none";
            switch (type) {
                case "car":
                    addTextField("Tipe Bahan Bakar", "tipe_bahan_bakar");
                    addTextField("Luas Bagasi", "luas_bagasi");
                    break;
                case "truck":
                    addTextField("Jumlah Roda", "jumlah_roda");
                    addTextField("Area Kargo", "area_kargo");
                    break;
                case "motorbike":
                    addTextField("Ukuran Bagasi", "ukuran_bagasi");
                    addTextField("Kapasitas Bensin", "kapasitas_bensin");
                    break;
                default:
                    break;
            }

            if (additionalFields.children.length > 0) {
                additionalFields.style.display = "block";
            }
        }

        function addTextField(label, name) {
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

            div.appendChild(labelElement);
            div.appendChild(inputElement);

            additionalFields.appendChild(div);
        }
    </script>
@endsection
