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
        <form action="{{ route('adminEmployee.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="mb-3">
                <label class="form-label">Employee Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $employee->name }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Employee Image</label>
                <input type="file" class="form-control" style="margin-bottom:5px" id="image" name="image">
                <a href="{{asset('storage/'.$employee->image)}}">
                    <img width="80" src="{{asset('storage/'.$employee->image)}}" alt="">
                </a>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone NO.</label>
                <input type="phone" class="form-control" id="phone" name="phone" value="{{ $employee->phone }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Employee email</label>
                <input type="email" class="form-control" id="employeeEmail" name="employeeEmail" value="{{ $employee->email }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter the employee email" value="{{ $employee->password}}">
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3">{{ $employee->address }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Ipan</label>
                <input type="text" class="form-control" id="ipan" name="ipan" value="{{ $employee->ipan }}">
            </div>
            <div class="mb-3">
                <input type="submit" value="Save" class="btn btn-info">
            </div>
        </form>
    </div>
@endsection
