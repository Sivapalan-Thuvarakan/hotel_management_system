@extends('layouts.main')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <ol class="d-flex breadcrumb bg-transparent p-0 justify-content-end">
                <li class="breadcrumb-item text-capitalize"><a href="/">Home</a></li>
                <li class="breadcrumb-item text-capitalizeactive" aria-current="page"><a
                        href="{{ route('suppliers.index') }}">Suppliers</a></li>
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
                                            <h4 style="color:red;"> Suppliers <small class="text-muted">List</small></h4>
                                        </div>
                                        <div>
                                            <a href="{{ route('suppliers.create') }}"
                                                class="btn btn-md btn-primary float-end"><i class="fa fa-plus"></i>Add
                                                Supplier</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm table-bordered" style="font-size: 14px">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Supplier Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Phone no</th>
                                                <th scope="col">Address</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($suppliers)
                                                @foreach ($suppliers as $supplier)
                                                    <tr>
                                                        <td>{{ $supplier->name }}</td>
                                                        <td>{{ $supplier->email }}</td>
                                                        <td>{{ $supplier->phone_no }}</td>
                                                        <td>{{ $supplier->address }}</td>
                                                        <td>
                                                            <a class="btn btn-sm btn-success"
                                                                href="{{ route('suppliers.show', $supplier->id) }}"><i
                                                                    class="fas fa-eye"></i></a>
                                                            <a class="btn btn-sm btn-warning"
                                                                href="{{ route('suppliers.edit', $supplier->id) }}"><i
                                                                    class="fas fa-edit"></i></a>
                                                            <button onclick="deleteConfirmation('{{ $supplier->id }}')"
                                                                class="btn btn-sm btn-danger mr-1"><i
                                                                    class="fas fa-trash"></i></button>
                                                            <form action="{{ route('suppliers.destroy', $supplier->id) }}"
                                                                method="post" id='form-data-{{ $supplier->id }}'>
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
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
                html: "You want to delete this Supplier",
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
