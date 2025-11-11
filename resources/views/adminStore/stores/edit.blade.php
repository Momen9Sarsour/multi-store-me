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
    <form action="{{route('adminStores.update',$store->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="mb-3">
            <label class="form-label">Store Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{$store->name}}">
        </div>
        <div class="mb-3">
            <label class="form-label">Store Image</label>
            <input type="file" class="form-control" style="margin-bottom:5px"  id="image" name="image">
            <a href="{{asset('images/uploads/'.$store->image)}}">
                <img width="80" src="{{asset('storage/'.$store->image)}}" alt="">
            </a>
        </div>
        <div class="form-group py-4">
            <label for="">Description</label>
            <textarea class="form-control" name="description">{{$store->description}}</textarea>
        </div>
        {{-- <div class="mb-3">
            <label class="form-label">Store email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{$store->email}}">
        </div>
        <div class="mb-3">
            <label class="form-label">Vendor ID</label>
            <input type="number" class="form-control" id="vendor_id" name="vendor_id" value="{{$store->vendor_id}}">
        </div> --}}
        <div class="mb-3">
            <label class="form-label">Phone NO.</label>
            <input type="phone" class="form-control" id="phone" name="phone"  value="{{$store->phone}}">
        </div>
        <div class="form-group py-4">
            <label for="">Status</label>
               <div>
                 <div class="form-check py-2">
                   <input class="form-check-input" type="radio" name="status" value="active" checked @checked($store->status =='active')>
                   <label class="form-check-label">Active</label>
                 </div>
                 <div class="form-check py-3">
                   <input class="form-check-input" type="radio" name="status" value="archived" @checked($store->status =='archived')>
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
