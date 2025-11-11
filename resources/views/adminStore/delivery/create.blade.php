@extends('adminStore.adminLayout')
@section('dashboard')

    <div class="container py-3">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('adminDelivery.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Delivery-man Name">
            </div>
            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image" placeholder="Delivery-man Image">
            </div>
            <div class="mb-3">
                <label class="form-label">Phone NO.</label>
                <input type="phone" class="form-control" id="phone" name="phone" placeholder="Delivery-man Phone NO.">
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" placeholder="Delivery-man Address" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">IPAN</label>
                <textarea class="form-control" id="ipan" name="ipan" placeholder="Delivery-man IPAN" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" id="deliveryEmail" name="deliveryEmail" placeholder="Delivery-man Email">
            </div>
            <div class="mb-3">
                <input type="submit" value="Save" class="btn btn-info">
            </div>
        </form>
    </div>

@endsection
