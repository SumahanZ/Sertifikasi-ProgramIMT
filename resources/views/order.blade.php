@extends("layouts.mainlayout")

@section("title", "Orders")

@section("content")
    <div class="container mt-5">
        <h1>Order List</h1>

        <div class="card mt-4">
            <div class="card-body">
                <div class="mb-3">
                    <a href="order-add" class="btn btn-success fw-bold">Add Order</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered custom-table-width">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="text-center">No.</th>
                                <th scope="col" class="text-center">Nama</th>
                                <th scope="col" class="text-center">Alamat</th>
                                <th scope="col" class="text-center">No. Telp</th>
                                <th scope="col" class="text-center">Id Card</th>
                                <th scope="col" class="text-center">Total Harga (Rp)</th>
                                <th scope="col" class="text-center">Kendaraan Yang Dibeli</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($orderList))
                                @foreach ($orderList as $order)
                                    <tr>
                                        @if (!empty($order->vehicles))
                                            <td class="align-middle text-center ">{{ $loop->iteration }}</td>
                                            <td class="align-middle text-center">{{ $order->customer->nama }}</td>
                                            <td class="align-middle text-center">{{ $order->customer->alamat }}</td>
                                            <td class="align-middle text-center">{{ $order->customer->no_telp }}</td>
                                            <td class="align-middle text-center">{{ $order->customer->id_card }}</td>
                                            <td class="align-middle text-center">Rp {{ number_format($totalPrices[$order->id], 2) }}</td>
                                            <td class="align-middle">
                                                <ol>
                                                    @foreach ($order->vehicles as $vehicle)
                                                    <li>
                                                        Model: {{ $vehicle->model }}<br>
                                                        Tahun: {{ $vehicle->tahun }}<br>
                                                        Tipe Kendaraan:
                                                        {{
                                                            $vehicle->vehicleable_type == "App\Models\Car" ? "Car" :
                                                            ($vehicle->vehicleable_type == "App\Models\Truck" ? "Truck" : "Motor Bike")
                                                        }}<br>
                                                        Jumlah Pesanan: {{ $vehicle->pivot->jumlah_kendaraan_dipesan }}<br>
                                                        Jumlah Penumpang: {{ $vehicle->jumlah_penumpang }}<br>
                                                        Manufaktur: {{ $vehicle->manufaktur }}<br>
                                                        Harga: Rp {{ number_format($vehicle->harga, 2) }}<br>
                                                    </li>
                                                    @endforeach
                                                </ol>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="order-edit/{{ $order->id }}" class="btn btn-warning btn-m fw-bold">Edit</a>
                                                <a href="order-delete/{{ $order->id }}" class="btn btn-danger btn-m ml-1 fw-bold">Delete</a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Define the width for the custom table */
        .custom-table-width {
            width: 100%; /* You can adjust the width percentage as needed */
        }
    </style>
@endsection
