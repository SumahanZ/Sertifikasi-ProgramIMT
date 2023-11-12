@extends("layouts.mainlayout")

@section("title", "Edit Customer")

@section("content")
<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">Edit Customer</h2>

            @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            <form action="/customer/{{ $customer->id }}" method="POST">
                @csrf 
                @method("PUT")  
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $customer->nama }}" required>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" required>{{ $customer->alamat }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="no_telp" class="form-label">No. Telepon</label>
                    <input type="tel" class="form-control" id="no_telp" name="no_telp" value="{{ $customer->no_telp }}" required>
                </div>

                <div class="mb-3">
                    <label for="id_card" class="form-label">ID Card</label>
                    <input type="text" class="form-control" id="id_card" name="id_card" value="{{ $customer->id_card }}" required>
                </div>

                <div class="d-grid gap-5">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
