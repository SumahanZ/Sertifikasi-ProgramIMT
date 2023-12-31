@extends("layouts.mainlayout")

@section("title", "Delete Order")

@section("content")
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">Confirm Deletion</h2>
            <p class="card-text">Are you sure you want to delete order data?</p>

            <form style="display: inline-block" action="/order-destroy/{{ $order->id }}" method="POST">
                @csrf
                @method("delete")
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>

            <a href="/orders" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</div>
@endsection
