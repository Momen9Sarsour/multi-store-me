@extends('adminStore.adminLayout')
@section('dashboard')
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

        <!--begin::Toolbar-->
        <div class="toolbar" id="kt_toolbar">
            <!--begin::Container-->
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <!--end::Page title-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                    <!--begin::Table head-->
                    <thead>
                        <!--begin::Table row-->
                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true"
                                        data-kt-check-target="#kt_customers_table .form-check-input" value="1" />
                                </div>
                            </th>
                            <th class="min-w-35px">ID</th>
                            <th class="min-w-125px">Name Product</th>
                            <th class="min-w-125px">Store Name</th>
                            <th class="min-w-125px">Category name</th>
                            <th class="min-w-125px">Image Product</th>
                            <th class="min-w-125px">Description</th>
                            <th class="min-w-125px">price</th>
                            <th class="min-w-125px">Status</th>
                            <th class="text-end min-w-70px">Actions</th>
                        </tr>
                        <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="fw-bold text-gray-600">
                        @forelse($products as $product)
                            <tr>
                                <!--begin::Checkbox-->
                                <td>
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" />
                                    </div>
                                </td>
                                <!--end::Checkbox-->
                                <td><a href="#" class="text-gray-600 text-hover-primary mb-1">{{ $product->id }}</a></td>
                                <td><a href="#" class="text-gray-600 text-hover-primary mb-1">{{ $product->name }}</a></td>
                                <td><a href="{{route('adminStores.show',$product->store->id)}}" class="text-gray-600 text-hover-primary mb-1">{{ $product->store->name }}</a></td>
                                <td><a href="{{route('adminCategory.show',$product->category->id)}}" class="text-gray-600 text-hover-primary mb-1">{{ $product->category->name }}</a></td>
                                <td><img width="80" src="{{asset('storage/'.$product->image)}}" alt="No Image"></a></td>
                                <td>{{ $product->description }}</td>
                                <td data-filter="mastercard">{{ $product->price }}</td>
                                <td>{{ $product->status }}</td>
                                <td class="text-end">
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
                                            <a href="{{ route('adminProduct.edit', $product->id) }}"
                                                class="btn btn-sm btn-outline-success ">Edit</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <form action="{{ route('adminProduct.destroy', $product->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    data-kt-customer-table-filter="delete_row">Delete</button>

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
                    <!--end::Table body-->
                </table>
                <div>
                    {{ $products->links() }}
                </div>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Post-->
    </div>
    {{-- <a href="{{ route('adminCategory.index') }}" class="btn btn-sm btn-primary">BACK</a> --}}
    {{-- <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary">BACK</a> --}}
    {{-- <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-sm btn-primary">BACK</a> --}}
    {{-- <a href="{{ URL::previous() }}" class="btn btn-sm btn-primary">BACK</a> --}}
    <a href="javascript:history.back()" class="btn btn-sm btn-primary">BACK</a>
    <!--end::Content-->
@endsection
