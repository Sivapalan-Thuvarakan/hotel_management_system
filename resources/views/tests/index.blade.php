@extends('layouts.main')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <ol class="d-flex breadcrumb bg-transparent p-0 justify-content-end">
            <li class="breadcrumb-item text-capitalize"><a href="/">Home</a></li>
            <li class="breadcrumb-item text-capitalizeactive" aria-current="page"><a href="{{route('tests.index')}}">Students</a></li>
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
                                        <h4>Student List</h4>
                                    </div>
                                    <div>
                                        <a href="{{route('tests.create')}}" class="btn btn-lg btn-primary float-end">Add Student</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-bordered border-primary">
                                    <thead>
                                    <tr>
                                        <th style="width: 25%">Name</th>
                                        <th style="width: 25%">Description</th>
                                        <th style="width: 25%">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if ($data)
                                        @foreach ($data as $item)
                                        <tr>
                                            <td style="width: 25%">{{$item->name}}</td>
                                            <td style="width: 25%">{{$item->description}}</td>
                                            <td style="width: 25%">
                                                <a class="btn btn-sm btn-success" href="{{route('tests.show',$item->id)}}"><i class="fas fa-eye"></i> Show</a>
                                                <a class="btn btn-sm btn-warning" href="{{route('tests.edit',$item->id)}}"><i class="fas fa-edit"></i> Edit</a>
                                                <button  onclick="deleteConfirmation('{{$item->id}}')" class="btn btn-sm btn-danger mr-1"><i class="fas fa-trash"></i> Delete</button>
                                                <form action="{{route('tests.destroy',$item->id)}}" method="post" id='form-data-{{$item->id}}'>
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
