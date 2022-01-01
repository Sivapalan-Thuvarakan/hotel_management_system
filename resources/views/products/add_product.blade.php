@extends('layouts.main')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <ol class="d-flex breadcrumb bg-transparent p-0 justify-content-end">
                <li class="breadcrumb-item text-capitalize"><a href="/">Home</a></li>
                <li class="breadcrumb-item text-capitalizeactive" aria-current="page"><a
                        href="{{ route('stocks.index') }}">Stocks</a></li>
            </ol>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="container">
                <main class="mx-auto m-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 style="color:red;"> Stock <small class="text-muted">List</small></h4>
                                        </div>
                                        <div>
                                            <a href="{{ route('stocks.create') }}"
                                                class="btn btn-md btn-primary float-end"><i class="fa fa-plus"></i>Add
                                                Stock</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-bordered" style="font-size: 14px">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Product Name</th>
                                                <th scope="col">Brand</th>
                                                <th scope="col">Purchase Price</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">status</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($stocks)
                                                @foreach ($stocks as $stock)
                                                    <tr>
                                                        <td>{{ $stock->product_name }}</td>
                                                        <td>{{ $stock->brand }}</td>
                                                        <td>{{ $stock->purchase_price }}</td>
                                                        <td>{{ $stock->quantity }}</td>
                                                        <td>{{ $stock->type }}</td>
                                                        <td>@if ($stock->is_product == 1)
                                                            <span class="badge badge-success">product</span>
                                                            @elseif ($stock->is_product == 0)
                                                            <span class="badge badge-danger">stock</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $stock->description }}</td>
                                                        <td>
                                                            <a class="btn btn-sm btn-success"
                                                            href="{{ route('stocks.show', $stock->id) }}"><i
                                                                class="fas fa-eye"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <th colspan="3">No Record</th>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function deleteConfirmation(id) {
            Swal.fire({
                title: 'Are you sure?',
                html: "You want to delete this Stock",
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "Yes, Delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-data-' + id).submit();
                }
            })
        }
    </script>
@endpush
