@extends('employeeAdmin.layoutEmployeeAdmin')
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
        <form action="{{ url('/employeeAdmin/stores/store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Store Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Store Name">
            </div>
            <div class="mb-3">
                <label for="imageFormControlInput" class="form-label">Store Image</label>
                <input type="file" class="form-control" id="image" name="image" placeholder="Store Image">
            </div>
            <div class="form-group py-4">
                <label for="">Description</label>
                <textarea class="form-control" name="description"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Store email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Store email">
            </div>
            <div class="mb-3">
                <label class="form-label">password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="password">
            </div>
            <div class="mb-3">
                <label class="form-label">Phone NO.</label>
                <input type="phone" class="form-control" id="phone" name="phone" placeholder="Store Phone Number">
            </div>
            <div class="form-group py-4">
                <label for="">Status</label>
                <div>
                    <div class="form-check py-2">
                        <input class="form-check-input" type="radio" name="status" value="active" checked>
                        <label class="form-check-label">Active</label>
                    </div>
                    <div class="form-check py-3">
                        <input class="form-check-input" type="radio" name="status" value="archived">
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
