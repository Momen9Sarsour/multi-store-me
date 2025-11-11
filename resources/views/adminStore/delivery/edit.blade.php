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
        <form action="{{ route('adminDelivery.update', $delivery->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Delivery-man Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $delivery->name }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Delivery-man Image</label>
                <input type="file" class="form-control" style="margin-bottom:5px" id="image" name="image">
                <img width="80" src="{{asset('storage/'.$delivery->image)}}" alt="">
            </div>
            <div class="mb-3">
                <label class="form-label">Phone NO.</label>
                <input type="phone" class="form-control" id="phone" name="phone" value="{{ $delivery->phone }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3">{{ $delivery->address }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Delivery-man IPAN</label>
                <input type="text" class="form-control" id="ipan" name="ipan" value="{{ $delivery->ipan }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Delivery-man email</label>
                <input type="email" class="form-control" id="deliveryEmail" name="deliveryEmail"
                    value="{{ $delivery->email }}">
            </div>
            <div class="mb-3">
                <input type="submit" value="Save" class="btn btn-info">
            </div>
        </form>
    </div>

@endsection
