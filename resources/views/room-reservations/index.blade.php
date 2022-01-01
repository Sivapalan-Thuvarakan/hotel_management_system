@extends('layouts.main')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <ol class="d-flex breadcrumb bg-transparent p-0 justify-content-end">
            <li class="breadcrumb-item text-capitalize"><a href="/">Home</a></li>
            <li class="breadcrumb-item text-capitalizeactive" aria-current="page"><a href="{{route('reservations.index')}}">Reservations</a></li>
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
                                <form action="{{route('reservations.index')}}" method="GET">
                                    <div class="row">
                                        <div class="mb-3 col-md-12">
                                            <label for="search" class="form-label">Search</label>
                                            <input type="text" class="form-control" id="search" name="search" value="{{ old('search',$search) }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="from" class="form-label">From</label>
                                            <input type="date" class="form-control" id="from" name="from" value="{{ $from != null ? $from : date('Y-m-d') }}">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="to" class="form-label">To</label>
                                            <input type="date" class="form-control" id="to" name="to" value="{{ $to != null ? $to : date('Y-m-d')  }}">
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
                                        <h4>Reservation List</h4>
                                    </div>
                                    <div>
                                        <a href="{{route('reservations.create')}}" class="btn btn-sm btn-primary float-end">Add Reservation</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-bordered" style="font-size: 14px">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th style="width: 10%">Room</th>
                                        <th style="width: 10%">Room Type</th>
                                        <th style="width: 10%">From</th>
                                        <th style="width: 10%">To</th>
                                        <th style="width: 25%">Customer</th>
                                        <th style="width: 25%">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if ($data)
                                        @foreach ($data as $item)
                                        <tr>
                                            <td style="width: 10%">{{$item->code}}</td>
                                            <td style="width: 10%">{{$item->room_type}}</td>
                                            <td style="width: 10%">{{$item->check_in_date}}</td>
                                            <td style="width: 10%">{{$item->check_out_date}}</td>
                                            <td style="width: 25%">{{$item->full_name}}</td>
                                            <td style="width: 25%">
                                                {{-- <a class="btn btn-sm btn-success" href="{{route('tests.show',$item->id)}}"><i class="fas fa-eye"></i> Show</a> --}}
                                                @if ($item->status == 'closed')
                                                <div class="btn btn-sm btn-secondary"><i class="fas fa-times"></i> Reservation Closed</div>
                                                @else
                                                <a class="btn btn-sm btn-warning" href="{{route('reservations.edit',$item->id)}}"><i class="fas fa-edit"></i> Handle Reservation</a>
                                                @endif
                                                {{-- <button  onclick="deleteConfirmation('{{$item->id}}')" class="btn btn-sm btn-danger mr-1"><i class="fas fa-trash"></i> Delete</button>
                                                <form action="{{route('reservations.destroy',$item->id)}}" method="post" id='form-data-{{$item->id}}'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form> --}}
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
