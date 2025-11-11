@extends('adminStore.adminLayout')

@section('dashboard')
<div class="container">
    @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session()->has('info'))
    <div class="alert alert-info">
        {{ session('info') }}
    </div>
    @endif
</div>

<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
            data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
            class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Orders List</h1>
            <!--end::Title-->
            <!--begin::Separator-->
            <span class="h-20px border-gray-200 border-start mx-4"></span>
            <!--end::Separator-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('admin/dashboard') }}" class="text-muted text-hover-primary">Home</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted"><a href="{{ route('adminOrder.index') }}"
                        class="text-muted text-hover-primary">Orders</a></li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-dark"><a href="{{ route('adminOrder.index') }}"
                        class="text-muted text-hover-primary">Order Listing</a></li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">
            <!--begin::Button-->
            <a href="{{ route('adminOrder.create') }}" class="btn btn-md btn-primary"
                id="kt_toolbar_primary_button">Add New Order</a>
            <!--end::Button-->
        </div>
        <!--end::Actions-->
    </div>
</div>
<!--end::Toolbar-->

<!--begin::Post-->
<div class="post d-flex flex-column-fluid mt-5" id="kt_post" style="margin-bottom: 20px;">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <form action="{{ route('adminOrder.index') }}" method="get">
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
                            <input type="text" name="search" value="{{ old('search', $search) }}"
                                data-kt-customer-table-filter="search"
                                class="form-control form-control-solid w-250px ps-15" placeholder="Search Customers" />
                        </div>
                        <div class="px-7 py-5">
                            <!--begin::Input group-->
                            <div>
                                <!--begin::Label-->
                                <select name="status" class="form-select"
                                    aria-label="Default select example">
                                    <option value=""
                                        @selected(request('status') == 'all')>All</option>
                                    <option value="Pending"
                                        @selected(request('status') == 'Pending')>Pending</option>
                                    <option value="processing"
                                        @selected(request('status') == 'processing')>Processing</option>
                                    <option value="delivering"
                                        @selected(request('status') == 'delivering')>Delivering</option>
                                    <option value="completed"
                                        @selected(request('status') == 'completed')>Completed</option>
                                    <option value="cancelled"
                                        @selected(request('status') == 'cancelled')>Cancelled</option>
                                    <option value="refunded"
                                        @selected(request('status') == 'refunded')>Refunded</option>
                                </select>
                                <!--end::Options-->
                            </div>
                        </div>
                        <!--end::Search-->
                        <button class="btn btn-sm btn-primary fs-4" type="submit">Filter</button>
                    </div>
                </form>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                        <!--begin::Add customer-->
                        <a href="{{ route('adminOrder.create') }}"
                            class="btn btn-primary">Add New Order </a>
                        <!--end::Add customer-->
                    </div>
                    <!--end::Toolbar-->
                    <!--begin::Group actions-->
                    <!--end::Group actions-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5"
                        id="kt_customers_table">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="w-10px pe-2">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox"
                                            data-kt-check="true"
                                            data-kt-check-target="#kt_customers_table .form-check-input"
                                            value="1" />
                                    </div>
                                </th>
                                <th class="min-w-25px">ID</th>
                                <th class="min-w-125px">User name</th>
                                <th class="min-w-125px">Store name</th>
                                <th class="min-w-125px">Delivery name</th>
                                <th class="min-w-125px">Product name</th>
                                <th class="min-w-125px">Image Product</th>
                                <th class="min-w-125px">Total Price</th>
                                <th class="min-w-125px">Address Order</th>
                                <th class="min-w-125px">Status</th>
                                <th class="min-w-70px">Actions</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-bold text-gray-600">
                            @forelse($orders as $order)
                            <tr>
                                <!--begin::Checkbox-->
                                <td>
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" />
                                    </div>
                                </td>
                                <!--end::Checkbox-->
                                <td><a href="#"
                                        class="text-gray-500 text-hover-primary mb-1">{{ $order->id }}</a></td>
                                <td><a href="#"
                                        class="text-gray-600 text-hover-primary mb-1">{{ $order->user->name }}</a></td>
                                <td><a href="#"
                                        class="text-gray-600 text-hover-primary mb-1">{{ $order->store->name }}</a>
                                </td>
                                <td><a href="#"
                                        class="text-gray-600 text-hover-primary mb-1">{{ $order->delivery->name }}</a>
                                </td>
                                <td>
                                    <a href="#"
                                        {{-- class="text-gray-600 text-hover-primary mb-1">{{ $order->product->name }} --}}
                                        @if ($order->product)
                                        <a href="#"
                                            class="text-gray-600 text-hover-primary mb-1">{{ $order->product->name }}</a>
                                        @else
                                        <span class="text-danger">Product not found</span>
                                        @endif
                                    </a>
                                    {{-- {{ optional($order->product)->name }} --}}
                                </td>
                                <td>
                                    <a>
                                        {{-- <img width="80" src="{{asset('storage/'.$order->product_id)}}"
                                            alt="No Image"> --}}
                                        @if ($order->product && $order->product->image)
                                        <img width="80" src="{{ asset('storage/' . $order->product->image) }}"
                                            alt="Product Image">
                                        @else
                                        <span class="text-danger">Image not available</span>
                                        @endif
                                    </a>
                                </td>
                                <td>{{ $order->total }}</td>
                                {{-- <td>{{ $order->addresses }}</td> --}}
                                <td data-filter="mastercard">Information Address</td>
                                <td>{{ $order->status }}</td>
                                <td class="">
                                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                        <span class="svg-icon svg-icon-5 m-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
                                                <path
                                                    d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                    fill="black" />
                                            </svg>
                                        </span>
                                    </a>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="{{ route('adminOrder.edit', $order->id) }}"
                                                class="btn btn-sm btn-outline-success">Edit</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <form action="{{ route('adminOrder.destroy', $order->id) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    data-kt-customer-table-filter="delete_row">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11">No deliveries defined.</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <!--end::Table body-->
                    </table>
                </div>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->

        <!--begin::Modal - Adjust Balance-->
        <div class="modal fade" id="kt_customers_export_modal" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bolder">Export Order</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div id="kt_customers_export_close"
                            class="btn btn-icon btn-sm btn-active-icon-primary">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16"
                                        height="2" rx="1"
                                        transform="rotate(-45 6 17.3137)"
                                        fill="black" />
                                    <rect x="7.41422" y="6" width="16" height="2"
                                        rx="1" transform="rotate(45 7.41422 6)"
                                        fill="black" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->

                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - New Card-->
        <!--end::Modals-->
    </div>
    <!--end::Container-->
</div>
<!--end::Post-->
@endsection
