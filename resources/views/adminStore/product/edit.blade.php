@extends('adminStore.adminLayout')
@section('dashboard')
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('adminProduct.update', $product->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group py-4">
                        <label for="">Product Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $product->name }}">
                    </div>
                    <div class="form-group py-4">
                        <label for="image">Image</label>
                        <input type="file" name="image" class="form-control" />
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="" height="60">
                        @endif
                    </div>
                    <div class="form-group py-4">
                        <label for="">Store Parent</label>
                        <select type="text" name="store_id" class="form-control form-select">
                            @foreach ($store as $store)
                                <option value="{{ $store->id }}"
                                    {{ $product->store_id == $store->id ? 'selected' : '' }}>
                                    {{ $store->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group py-4">
                        <label for="">Category Parent</label>
                        <select type="text" name="category_id" class="form-control form-select">
                            <option value="">Primary Category</option>
                            @foreach ($category as $category)
                                <option value="{{ $category->id }}"
                                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group py-4">
                        <label for="">Description</label>
                        <textarea class="form-control" name="description">{{ $product->description }}</textarea>
                    </div>
                    <div class="form-group py-4">
                        <label for="">Price</label>
                        <input type="number" name="price" class="form-control" value="{{ $product->price }}">
                    </div>
                    <div class="form-group py-4">
                        <label for="">Compare Price</label>
                        <input type="number" name="compare_price" class="form-control"
                            value="{{ $product->compare_price }}">
                    </div>
                    <div class="form-group py-4">
                        <label for="">Storge Quantity</label>
                        <input type="number" name="storgeQuantity" class="form-control"
                            value="{{ $product->storgeQuantity }}">
                    </div>
                    <div class="form-group py-4">
                        <label for="">Status</label>
                        <div>
                            <div class="form-check py-2">
                                <input class="form-check-input" type="radio" name="status" value="active" checked
                                    @checked($category->status == 'active')>
                                <label class="form-check-label">Active</label>
                            </div>
                            <div class="form-check py-3">
                                <input class="form-check-input" type="radio" name="status" value="archived"
                                    @checked($category->status == 'archived')>
                                <label class="form-check-label">Archived</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>

                </form>
            </div>

            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Content-->
@endsection
