@extends('layouts.main')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <ol class="d-flex breadcrumb bg-transparent p-0 justify-content-end">
            <li class="breadcrumb-item text-capitalize"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item text-capitalizeactive" aria-current="page"><a href="{{route('roles.index')}}">Roles</a></li>
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
                                        <h4>Roles </h4>
                                    </div>
                                    <div>
                                        <a href="{{route('roles.create')}}" class="btn btn-sm btn-primary float-end">Add Role</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-bordered" style="font-size: 14px">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th style="width: 10%">Name</th>
                                        <th style="width: 80%">Permissions</th>
                                        <th style="width: 10%">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $role)
                                        <tr>
                                            <td style="width: 10%">{{$role->name}}</td>
                                            <td style="width: 80%"><div>
                                                @foreach($role->permissions as $permission)
                                                    @php
                                                        $permission_name = ucfirst(str_replace('-',' ',$permission->name));
                                                    @endphp
                                                    @if(strpos($permission_name,'delete'))
                                                        <span class="badge badge-pill bg-danger"> {{ $permission_name }}</span>
                                                    @elseif(strpos($permission_name,'edit'))
                                                        <span class="badge badge-pill bg-secondary"> {{ $permission_name }}</span>
                                                    @elseif(strpos($permission_name,'add'))
                                                        <span class="badge badge-pill bg-success"> {{ $permission_name }}</span>
                                                    @else
                                                        <span class="badge badge-pill bg-primary"> {{ $permission_name }}</span>
                                                    @endif


                                                @endforeach
                                            </div>
                                            <td style="width: 10%">
                                                {{-- <a class="btn btn-sm btn-success" href="{{route('roles.show',$role->id)}}"><i class="fas fa-eye"></i> Show</a> --}}
                                                <a class="btn btn-sm btn-warning" href="{{route('roles.edit',$role->id)}}"><i class="fas fa-edit"></i></a>
                                                {{-- <button  onclick="deleteConfirmation('{{$role->id}}')" class="btn btn-sm btn-danger mr-1"><i class="fas fa-trash"></i> Delete</button>
                                                <form action="{{route('roles.destroy',$role->id)}}" method="post" id='form-data-{{$role->id}}'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form> --}}
                                            </td>
                                        </tr>
                                        @endforeach
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
