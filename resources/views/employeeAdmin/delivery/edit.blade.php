@extends('employeeAdmin.layoutEmployeeAdmin')
@section('dashboard')

<div class="container py-3">
    {{-- <form action="{{url('/admin/stores/update/'.$product->id)}}" method="post" enctype="multipart/form-data"> --}}
    <form action="{{url('/employeeAdmin/delivery/update/'.$delivery->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="nameFormControlInput" class="form-label">Name delivery</label>
            {{-- <input type="text" class="form-control" id="name" name="name" value="{{$delivery->name}}" placeholder="Name delivery"> --}}
            <input type="text" class="form-control" id="name" name="name" value="{{$delivery->name}}" placeholder="Name Delivery">
        </div>
        <div class="mb-3">
            <label for="imageFormControlInput"  class="form-label">Image delivery</label>
            <input type="file" class="form-control" style="margin-bottom:5px"  id="image" name="image" placeholder="Image Delivery">
            <img width="80" src="{{asset('images/uploads/'. $delivery->image)}}" alt="">
        </div>
        <div class="mb-3">
            <label for="quantityFormControlInput" class="form-label">Phone</label>
            {{-- <input type="number" class="form-control" id="phone" name="phone" value="{{$delivery->phone}}" placeholder="Phone"> --}}
            <input type="phone" class="form-control" id="phone" name="phone" value="{{$delivery->phone}}" placeholder="Phone">
        </div>
        <div class="mb-3">
            <label for="descriptionFormControlTextarea" class="form-label">Address</label>
            {{-- <textarea class="form-control" id="address" name="address"  rows="3">{{$delivery->address}}</textarea> --}}
            <textarea class="form-control" id="address" name="address"  rows="3">{{$delivery->address}}</textarea>
        </div>
        <div class="mb-3">
            <label for="priceFormControlInput"  class="form-label">delivery Ipan</label>
            {{-- <input type="email" class="form-control" id="price" name="price" value="{{$delivery->ipan}}" placeholder="سعر المنتج"> --}}
            <input type="text" class="form-control" id="ipan" name="ipan" value="{{$delivery->ipan}}" placeholder="Delivery Ipan">
        </div>
        <div class="mb-3">
            <label for="priceFormControlInput"  class="form-label">delivery email</label>
            {{-- <input type="email" class="form-control" id="price" name="price" value="{{$delivery->email}}" placeholder="سعر المنتج"> --}}
            <input type="email" class="form-control" id="deliveryEmail" name="deliveryEmail" value="{{$delivery->email}}" placeholder="Delivery Email">
        </div>
        <div class="mb-3">
            <input type="submit" value="Save" class="btn btn-info">
        </div>
    </form>
</div>

@endsection
