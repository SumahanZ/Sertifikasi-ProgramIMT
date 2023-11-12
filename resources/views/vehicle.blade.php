@extends("layouts.mainlayout")

@section("title", "Students")

@section("content")
    <div class="container mt-5">
        <h1>Vehicles List</h1>

        @if(Session::has("status"))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get("message") }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card mt-4">
            <div class="card-body">
                <div class="mb-3">
                    <a href="/vehicle-add" class="btn btn-success fw-bold">Add Vehicle</a>
                </div>
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Tipe Kendaraan</th>
                            <th scope="col">Model</th>
                            <th scope="col">Tahun Dibuat</th>
                            <th scope="col">Jumlah Penumpang</th>
                            <th scope="col">Manufaktur</th>
                            <th scope="col">Harga (Rp)</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($carList))
                            @foreach ($carList as $car)
                                @if($car->vehicle)
                                    <tr>
                                        <td class="align-middle">Car</td>
                                        <td class="align-middle">{{ $car->vehicle->model }}</td>
                                        <td class="align-middle">{{ $car->vehicle->tahun }}</td>
                                        <td class="align-middle">{{ $car->vehicle->jumlah_penumpang }}</td>
                                        <td class="align-middle">{{ $car->vehicle->manufaktur }}</td>
                                        <td class="align-middle">Rp {{ number_format($car->vehicle->harga, 2) }}</td>
                                        <td class="align-middle">
                                            <a href="vehicle-detail/{{ $car->vehicle->id }}" class="btn btn-info btn-m fw-bold">Detail</a>
                                            <a href="vehicle-edit/{{ $car->vehicle->id }}" class="btn btn-warning btn-m fw-bold">Edit</a>
                                            <a href="vehicle-delete/{{ $car->vehicle->id }}" class="btn btn-danger btn-m ml-1 fw-bold">Delete</a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif

                        @if (!empty($truckList))
                            @foreach ($truckList as $truck)
                                @if($truck->vehicle)
                                <tr>
                                    <td class="align-middle">Truck</td>
                                    <td class="align-middle">{{ $truck->vehicle->model }}</td>
                                    <td class="align-middle">{{ $truck->vehicle->tahun }}</td>
                                    <td class="align-middle">{{ $truck->vehicle->jumlah_penumpang }}</td>
                                    <td class="align-middle">{{ $truck->vehicle->manufaktur }}</td>
                                    <td class="align-middle">Rp {{ number_format($truck->vehicle->harga, 2) }}</td>
                                    <td class="align-middle">
                                        <a href="vehicle-detail/{{ $truck->vehicle->id }}" class="btn btn-info btn-m fw-bold">Detail</a>
                                        <a href="vehicle-edit/{{ $truck->vehicle->id }}" class="btn btn-warning btn-m ml-1 fw-bold">Edit</a>
                                        <a href="vehicle-delete/{{ $truck->vehicle->id }}" class="btn btn-danger btn-m ml-1 fw-bold">Delete</a>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        @endif

                        @if (!empty($motorBikeList))
                            @foreach ($motorBikeList as $bike)
                                @if($bike->vehicle)
                                    <tr>
                                        <td class="align-middle">Motor Bike</td>
                                        <td class="align-middle">{{ $bike->vehicle->model }}</td>
                                        <td class="align-middle">{{ $bike->vehicle->tahun }}</td>
                                        <td class="align-middle">{{ $bike->vehicle->jumlah_penumpang }}</td>
                                        <td class="align-middle">{{ $bike->vehicle->manufaktur }}</td>
                                        <td class="align-middle">Rp {{ number_format($bike->vehicle->harga, 2) }}</td>
                                        <td class="align-middle">
                                            <a href="vehicle-detail/{{ $bike->vehicle->id }}" class="btn btn-info btn-m fw-bold">Detail</a>
                                            <a href="vehicle-edit/{{ $bike->vehicle->id }}" class="btn btn-warning btn-m ml-1 fw-bold">Edit</a>
                                            <a href="vehicle-delete/{{ $bike->vehicle->id }}" class="btn btn-danger btn-m ml-1 fw-bold">Delete</a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
