@extends("layouts.mainlayout")

@section("title", "Students")

@section("content")
    <div class="container mt-5">
        <h1>Customer List</h1>

        @if(Session::has("status"))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get("message") }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        <div class="card mt-4">
            <div class="card-body">
                <div class="mb-3">
                    <a href="customer-add" class="btn btn-success fw-bold">Add Customer</a>
                </div>

                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">No. Telp</th>
                            <th scope="col">Id Card</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($customerList))
                        @foreach ($customerList as $customer)
                            <tr>
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $customer->nama }}</td>
                                <td class="align-middle">{{ $customer->alamat }}</td>
                                <td class="align-middle">{{ $customer->no_telp }}</td>
                                <td class="align-middle">{{ $customer->id_card }}</td>
                                <td class="align-middle ">
                                    <a href="customer-edit/{{ $customer->id }}" class="btn btn-warning btn-m fw-bold">Edit</a>
                                    <a href="customer-delete/{{ $customer->id }}" class="btn btn-danger btn-m ml-1 fw-bold">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
