@extends('adminStore.adminLayout')
@section('dashboard')

<div class="container py-3">
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{route('adminEmployee.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Employee Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter the employee name" value="{{old('name')}}">
        </div>
        <div class="mb-3">
            <label class="form-label">Employee Image</label>
            <input type="file" class="form-control" id="image" name="image" placeholder="Upload the employee image">
        </div>
        <div class="mb-3">
            <label for="quantityFormControlInput" class="form-label">Phone</label>
            <input type="phone" class="form-control" id="phone" name="phone" placeholder="Phone number" value="{{old('phone')}}">
        </div>
        <div class="mb-3">
            <label class="form-label">Employee Email</label>
            <input type="email" class="form-control" id="employeeEmail" name="employeeEmail" placeholder="Enter the employee email" value="{{old('employeeEmail')}}">
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter the employee email" value="{{old('employeeEmail')}}">
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" placeholder="Enter the employee address" rows="3" value="{{old('address')}}"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">IPAN</label>
            <input type="text" class="form-control" id="ipan" name="ipan" placeholder="Enter the employee IPAN" value="{{old('ipan')}}">
        </div>
        <div class="mb-3">
            <input type="submit" value="Save" class="btn btn-info">
        </div>
    </form>
</div>

@endsection
