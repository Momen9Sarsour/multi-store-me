@extends('employeeAdmin.layoutEmployeeAdmin')
@section('dashboard')

<div class="container py-3">
    {{-- <form action="{{url('products/store')}}" method="post" enctype="multipart/form-data"> --}}
    <form action="{{route('employeeAdmin/delivery/store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="nameFormControlInput" class="form-label">Name Delivery</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Name Delivery">
        </div>
        <div class="mb-3">
            <label for="imageFormControlInput" class="form-label">Image Delivery</label>
            <input type="file" class="form-control" id="image" name="image" placeholder="Image Delivery">
        </div>
        <div class="mb-3">
            <label for="quantityFormControlInput" class="form-label">Phone</label>
            <input type="phone" class="form-control" id="phone" name="phone" placeholder="Phone">
        </div>
        <div class="mb-3">
            <label for="descriptionFormControlTextarea" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" placeholder="Address" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="descriptionFormControlTextarea" class="form-label">ipan</label>
            <textarea class="form-control" id="ipan" name="ipan" placeholder="ipan" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="priceFormControlInput" class="form-label">delivery email</label>
            <input type="email" class="form-control" id="deliveryEmail" name="deliveryEmail" placeholder="Delivery Email">
        </div>
        <div class="mb-3">
            <input type="submit" value="Save" class="btn btn-info">
        </div>
    </form>
</div>

@endsection
