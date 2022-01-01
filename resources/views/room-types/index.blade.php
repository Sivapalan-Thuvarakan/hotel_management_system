@extends('layouts.main')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <ol class="d-flex breadcrumb bg-transparent p-0 justify-content-end">
            <li class="breadcrumb-item text-capitalize"><a href="/">Home</a></li>
            <li class="breadcrumb-item text-capitalizeactive" aria-current="page"><a href="{{route('room_types.index')}}">Room Types</a></li>
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
                                        <h4>Room Types List</h4>
                                    </div>
                                    <div>
                                        <a href="{{route('room_types.create')}}" class="btn btn-sm btn-primary float-end">Add Room Type</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-bordered" style="font-size: 14px">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th style="width: 20%">Name</th>
                                        <th style="width: 20%">Rental price</th>
                                        <th style="width: 20%">Reservation Fee Percentage</th>
                                        <th style="width: 20%">Description</th>
                                        <th style="width: 20%">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if ($data)
                                        @foreach ($data as $item)
                                        <tr>
                                            <td style="width: 20%">{{$item->name}}</td>
                                            <td style="width: 20%">{{$item->rental_price}}</td>
                                            <td style="width: 20%">{{$item->reservation_fee_percentage}}</td>
                                            <td style="width: 20%">{{$item->description}}</td>
                                            <td style="width: 20%">
                                                <a class="btn btn-sm btn-success" href="{{route('room_types.show',$item->id)}}"><i class="fas fa-eye"></i></a>
                                                <a class="btn btn-sm btn-warning" href="{{route('room_types.edit',$item->id)}}"><i class="fas fa-edit"></i></a>
                                                <button  onclick="deleteConfirmation('{{$item->id}}')" class="btn btn-sm btn-danger mr-1"><i class="fas fa-trash"></i></button>
                                                <form action="{{route('room_types.destroy',$item->id)}}" method="post" id='form-data-{{$item->id}}'>
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
