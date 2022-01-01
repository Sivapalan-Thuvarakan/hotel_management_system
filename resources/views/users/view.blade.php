@extends('layouts.main')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <ol class="d-flex breadcrumb bg-transparent p-0 justify-content-end">
            <li class="breadcrumb-item text-capitalize"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item text-capitalize"><a href="{{route('users.index')}}">Users</a></li>
            <li class="breadcrumb-item text-capitalize active" aria-current="page">View User</li>
        </ol>
    </div>
</div>
<section class="content">
    {{-- <div class="container-fluid"> --}}
        <div class="container">
            <main class="mx-auto m-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>View User</h4>
                                    </div>
                                    <div>
                                        <a href="{{route('users.index')}}" class="btn btn-sm btn-warning float-end">Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="card-body">
                                        <div class="card-item">
                                            <table class="table-list-view">
                                                <tr>
                                                <td><strong>Name</strong></td>
                                                <td><strong>:</strong></td>
                                                <td>{{$user->name}}</td>
                                                </tr>
                                                <tr>
                                                <td><strong>Email</strong></td>
                                                <td><strong>:</strong></td>
                                                <td>{{$user->email}}</td>
                                                </tr>
                                                <tr>
                                                <td><strong>User Status</strong></td>
                                                <td><strong>:</strong></td>
                                                <td>
                                                    @if ($user->is_active == 1)
                                                    <span class="badge badge-success">Active</span>
                                                    @else
                                                    <span class="badge badge-danger">InActive</span>
                                                    @endif
                                                </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mt-2">

                                    <button  onclick="changeStatus('{{$user->id}}')" class="btn btn-sm @if ($user->is_active == 1)  btn-danger   @else btn-success   @endif mr-1">@if ($user->is_active == 1) InActivate @else Activate  @endif</button>
                                    <form action="{{route('users.update',$user->id)}}" method="post" id='form-data'>
                                        @csrf
                                        @method('PUT')
                                    </form>
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
function changeStatus(id){
Swal.fire({
        title: 'Are you sure?',
        html: "You want to change this user status" ,
        icon:  'error',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Yes, Change it!"
    }).then((result) => {
        if (result.isConfirmed) {
        $('#form-data').submit();
        }
    })
}
</script>
@endpush
