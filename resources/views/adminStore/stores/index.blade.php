@extends('adminStore.adminLayout')

@section('dashboard')
<div class="container">
    @if (session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
</div>

<div class="toolbar" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
            data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
            class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Stores List</h1>
            <span class="h-20px border-gray-200 border-start mx-4"></span>
            <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('admin/dashboard') }}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted"><a href="{{ route('adminStores.index') }}" class="text-muted text-hover-primary">Stores</a></li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-dark"><a href="{{ route('adminStores.index') }}" class="text-muted text-hover-primary">Stores Listing</a></li>
            </ul>
        </div>
    </div>
</div>

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

<div class="post d-flex flex-column-fluid mt-5" id="kt_post" style="margin-bottom: 20px">
    <div id="kt_content_container" class="container-xxl">
        <div class="card">
            <div class="card-header border-0 pt-6">
                <form action="{{ route('adminStores.index') }}" method="get">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                    <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                                </svg>
                            </span>
                            <input type="text" name="search" value="{{ old('search', $search) }}" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Customers" />
                        </div>
                        <div class="px-7 py-5">
                            <div>
                                <select name="status" class="form-select" aria-label="Default select example">
                                    <option value="" @if(request('status') == 'all') selected @endif>All</option>
                                    <option value="active" @if(request('status') == 'active') selected @endif>Active</option>
                                    <option value="archived" @if(request('status') == 'archived') selected @endif>Archived</option>
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-primary fs-4" type="submit">Filter</button>
                    </div>
                </form>
                <div class="card-toolbar">
                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                        <a href="{{ route('adminStores.create') }}" class="btn btn-primary">Add Store</a>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div style="overflow-x: auto;">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                        <thead>
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="w-10px pe-2">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_customers_table .form-check-input" value="1" />
                                    </div>
                                </th>
                                <th class="min-w-35px">ID</th>
                                <th class="min-w-125px">Store Name</th>
                                <th class="min-w-125px">Store Slug</th>
                                <th class="min-w-125px">Image Store</th>
                                <th class="min-w-125px">Description</th>
                                <th class="min-w-125px">Store Email</th>
                                <th class="min-w-125px">Password</th>
                                <th class="min-w-125px">Phone</th>
                                <th class="min-w-125px">Stauts</th>
                                <th class="min-w-70px">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="fw-bold text-gray-600">
                            @forelse($stores as $store)
                            <tr>
                                <td>
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" />
                                    </div>
                                </td>
                                <td><a href="{{ route('adminStores.show', $store->id) }}" class="text-gray-800 text-hover-primary mb-1">{{ $store->id }}</a></td>
                                <td><a href="{{ route('adminStores.show', $store->id) }}" class="text-gray-600 text-hover-primary mb-1">{{ $store->name }}</a></td>
                                <td>{{ $store->slug }}</td>
                                <td><img width="80" src="{{ asset('storage/' . $store->image) }}" alt="No image employee" /></a></td>
                                <td>{{ $store->description }}</td>
                                <td data-filter="mastercard">{{ $store->email }}</td>
                                <td>{{ $store->password }}</td>
                                <td>{{ $store->phone }}</td>
                                <td>{{ $store->status }}</td>
                                <td class="">
                                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                        <span class="svg-icon svg-icon-5 m-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" />
                                            </svg>
                                        </span>
                                    </a>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <a href="{{ route('adminStores.edit', $store->id) }}" class="btn btn-sm btn-outline-success">Edit</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <form action="{{ route('adminStores.destroy', $store->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" data-kt-customer-table-filter="delete_row">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">No categories defined.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
