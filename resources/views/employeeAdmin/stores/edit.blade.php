@extends('employeeAdmin.layoutEmployeeAdmin')
@section('dashboard')

<div class="container py-3">
    <form action="{{url('/employeeAdmin/stores/update/'.$store->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="mb-3">
            <label class="form-label">Store Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{$store->name}}">
        </div>
        <div class="mb-3">
            <label class="form-label">Store Image</label>
            <input type="file" class="form-control" id="image" name="image" >
            <img width="80" src="{{asset('images/uploads/'. $store->image)}}" alt="">
        </div>
        <div class="form-group py-4">
            <label for="">Description</label>
            <textarea class="form-control" name="description"> {{$store->description}} </textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Store email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{$store->email}}">
        </div>
        <div class="mb-3">
            <label class="form-label">password</label>
            <input type="password" class="form-control" id="password" name="password" value="{{$store->password}}">
        </div>
        <div class="mb-3">
            <label class="form-label">Phone NO.</label>
            <input type="phone" class="form-control" id="phone" name="phone" value="{{$store->phone}}">
        </div>
        <div class="form-group py-4">
            <label for="">Status</label>
            <div>
                <div class="form-check py-2">
                    <input class="form-check-input" type="radio" name="status" value="active" checked
                        @checked($store->status == 'active')>
                    <label class="form-check-label">Active</label>
                </div>
                <div class="form-check py-2">
                    <input class="form-check-input" type="radio" name="status" value="archived"
                        @checked($store->status == 'archived')>
                    <label class="form-check-label">Archived</label>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <input type="submit" value="Save" class="btn btn-info">
        </div>
    </form>
</div>

@endsection
