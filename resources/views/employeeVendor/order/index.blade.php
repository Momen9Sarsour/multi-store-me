
@extends('employeeVendor.layoutemployeeVendor')
@section('dashboard')

<div class="content" style="width: 99%">
    <div class="row">
        <div class="col-md-12">
            {{-- <h4 class="card-title"> Employee Vendor - Orders </h4> --}}

            <div class="card">
                <div class="card-header d-flex mt-4">
                    <div class="col-md-9">
                        <h4 class="card-title"> Employee Vendor - Orders </h4>
                    </div>
                    <div class="card">
                        <!--begin::Card header-->
                        <div class="card-header border-0 pt-6">
                            <!--begin::Card title-->
                            <form action="{{route('employeeVendor/order')}}" method="get">
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
                                        <input type="text" name="search" value="{{ old('search', $search) }}" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Orders" />
                                    </div>
                                    <div class="px-7 py-5">
                                        <!--begin::Input group-->
                                        <div>
                                            <!--begin::Label-->
                                            <select name="status" class="form-select" aria-label="Default select example">
                                                <option value="" @selected(request('status')== 'all')>All</option>
                                                <option value="Pending" @selected(request('status')== 'Pending')>Pending</option>
                                                <option value="Delivered" @selected(request('status')== 'Delivered')>Delivered</option>
                                                <option value="Accepted" @selected(request('status')== 'Accepted')>Accepted</option>
                                              </select>

                                            <!--end::Options-->
                                        </div>
                                    </div>
                                    <!--end::Search-->
                                    <button class="btn btn-sm btn-primary fs-4" type="submit">Filter</button>
                                </div>
                            </form>
                </div>

                <div class="col-md-3">
                    <a href="{{route('employeeVendor/order/create')}}" class="btn btn-primary">Add Order </a>
                        </div>
                <div class="card-body">
                    <div class="table-responsive">
                        {{-- @if (Auth::id()) --}}
                        <table class="table tablesorter " id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th>#</th>
                                    <th>user_id</th>
                                    <th>delivery_id</th>
                                    <th>product_id</th>
                                    <th>price_total</th>
                                    <th>Adress</th>
                                    <th>status</th>
                                    <th>Action</th>
                                </tr>


                            </thead>
                            <tbody>
                                @foreach($order as $order)
                                <tr>
                                    <td>{{$order->id}}</td>
                                    <td>{{$order->user_id}}</td>
                                    <td>{{$order->delivery_id}}</td>
                                    <td>{{$order->product_id}}</td>
                                    <td>{{$order->price_total}}</td>
                                    <td>{{$order->address}}</td>
                                    <td>{{$order->status}}</td>
                                    <td>
                                        <a href="{{route('employeeVendor/order/edit',$order->id)}}" class=" btn btn-info">Edit</a>
                                        <form action="{{route('employeeVendor/order/delete',$order->id)}}" method='post' class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type='submit' class=" btn btn-danger">Delete</button>
                                        </form>
                                   </td>
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

