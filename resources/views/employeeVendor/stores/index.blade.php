@extends('employeeVendor.layoutemployeeVendor')
@section('dashboard')

<div class="content" style="width: 99%">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex mt-4">
                    <div class="col-md-9">
                        <h4 class="card-title"> Employee Vendor - Stores </h4>
                    </div>
                    <div class="card">
                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-6">
                            <form action="{{route('employeeVendor/stores')}}" method="get">
                                <div class="card-title">
                                    <!--begin::Search-->
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <input type="text" name="search" value="{{ old('search', $search) }}" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Stores" />
                                    </div>
                                    <div class="px-7 py-5">
                                        <!--begin::Input group-->
                                        <div>
                                            <!--begin::Label-->
                                            <select name="status" class="form-select" aria-label="Default select example">
                                                <option value="" @selected(request('status')== 'all')>All</option>
                                                <option value="active" @selected(request('status')== 'active')>Active</option>
                                                <option value="archived" @selected(request('status')== 'archived')>Archived</option>
                                              </select>

                                            <!--end::Options-->
                                        </div>
                                    </div>
                                    <!--end::Search-->
                                    <button class="btn btn-sm btn-primary fs-4" type="submit">Filter</button>
                                </div>
                            </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">

                     {{-- @if (Auth::id()) --}}



                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Store Name</th>
                                    <th>Image Store</th>
                                    <th>description</th>
                                    <th>Vendor Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($store as $store)
                                <tr>
                                    <td>{{$store->id}}</td>
                                    <td>{{$store->name}}</td>
                                    <td><img width="80" src="{{asset('images/uploads/'. $store->image)}}" alt="No image employee"></td>
                                    <td>{{$store->description}}</td>
                                    <td>{{$store->email}}</td>
                                    <td>{{$store->phone}}</td>
                                    <td>{{$store->status}}</td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- @endif --}}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>




@endsection
