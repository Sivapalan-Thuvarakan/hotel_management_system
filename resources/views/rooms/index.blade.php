@extends('layouts.main')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <ol class="d-flex breadcrumb bg-transparent p-0 justify-content-end">
            <li class="breadcrumb-item text-capitalize"><a href="/">Home</a></li>
            <li class="breadcrumb-item text-capitalizeactive" aria-current="page"><a href="{{route('rooms.index')}}">Rooms</a></li>
        </ol>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="container">
            <main class="mx-auto m-4">

                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{route('rooms.index')}}" method="GET">
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="search" class="form-label">Search</label>
                                            <input type="text" class="form-control" id="search" name="search" value="{{ old('search',$search) }}">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                        <label for="status" class="form-label">Status</label>
                                        <select type="text" class="form-control" id="status" name="status" value="{{ old('status') }}">
                                            <option value="All" {{$status == "All" ? 'selected' : ''}}>All</option>
                                            <option value="open" {{$status == "open" ? 'selected' : ''}}>Open</option>
                                            <option value="reserved" {{$status == "reserved" ? 'selected' : ''}}>Reserved</option>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-success btn-sm border-rounded"><i class="fas fa-filter"></i> Filter</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>Rooms List</h4>
                                    </div>
                                    <div>
                                        <a href="{{route('rooms.create')}}" class="btn btn-sm btn-primary float-end">Add Room</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-bordered" style="font-size: 14px">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th style="width: 25%">Code</th>
                                        <th style="width: 25%">Rental price</th>
                                        <th style="width: 25%">Status </th>
                                        <th style="width: 25%">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if ($data)
                                        @foreach ($data as $item)
                                        <tr>
                                            <td style="width: 25%">{{$item->code}}</td>
                                            <td style="width: 25%">{{$item->roomTypes->rental_price}}</td>
                                            @if ($item->status == 'open' )
                                            <td style="width: 25%"><span class="badge badge-secondary">Open</span></td>
                                            @else
                                            <td style="width: 25%"><span class="badge badge-success">Reserved</span></td>
                                            @endif
                                            <td style="width: 25%">
                                                <a class="btn btn-sm btn-success" href="{{route('rooms.show',$item->id)}}"><i class="fas fa-eye"></i></a>
                                                <a class="btn btn-sm btn-warning" href="{{route('rooms.edit',$item->id)}}"><i class="fas fa-edit"></i></a>
                                                <button  onclick="deleteConfirmation('{{$item->id}}')" class="btn btn-sm btn-danger mr-1"><i class="fas fa-trash"></i></button>
                                                <form action="{{route('rooms.destroy',$item->id)}}" method="post" id='form-data-{{$item->id}}'>
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
                                <div class="float-right">
                                    {{$data->links('pagination::bootstrap-4')}}
                                </div>
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
    function deleteConfirmation(id){
        Swal.fire({
                  title: 'Are you sure?',
                  html: "You want to delete this record" ,
                  icon:  'error',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: "Yes, Delete it!"
                }).then((result) => {
                  if (result.isConfirmed) {
                   $('#form-data-'+id).submit();
                  }
                })
      }
</script>
@endpush
