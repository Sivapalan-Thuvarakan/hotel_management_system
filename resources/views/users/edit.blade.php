@extends('layouts.main')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <ol class="d-flex breadcrumb bg-transparent p-0 justify-content-end">
            <li class="breadcrumb-item text-capitalize"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item text-capitalize"><a href="{{route('users.index')}}">Users</a></li>
            <li class="breadcrumb-item text-capitalize active" aria-current="page">Update User</li>
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
                                        <h4>Update User</h4>
                                    </div>
                                    <div>
                                        <a href="{{route('users.index')}}" class="btn btn-sm btn-warning float-end">Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{route('users.update',$user->id)}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name',$user->name) }}">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    </div>
                                    <div>
                                    @if ($user->roles()->first()->id !== 1)
                                            <div class="col-12 col-md-4" id="role">
                                                <div class="mb-3">
                                                    <label for="role" class="form-label">Role</label>
                                                    <select class="form-control" onchange="roleGetPermission()" name="role">
                                                        @foreach ($roles as $obj)
                                                            <option value="{{$obj->id}}" {{old('role',$user->roles->first()->id) == $obj->id ? 'selected' : ''}}>{{$obj->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12">
                                                <div class="mb-3">
                                                    <label for="description" class="form-label">Authorities</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <roleset>
                                                        <legend></legend>
                                                        <label class="checkboxLabel"><label>Check All Authorities</label>
                                                            <input type="checkbox" id="check-all" onchange="onChangeClickCheckAll('all')">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </roleset>
                                                </div>
                                            </div>
                                            <div class="row" id="">
                                                @forelse ($permissions as $key => $permissionGroup)
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <roleset>
                                                                <legend>{{$key}}
                                                                    <label class="checkboxLabel">
                                                                        <input type="checkbox" class="permission-group-check" id="permission-group-id-{{$key}}" onclick="selectSubGroup('{{str_replace('','-',$key)}}')" >
                                                                    </label>
                                                                </legend>
                                                                @forelse ($permissionGroup as $permission)
                                                                    <div>
                                                                        <label class="checkboxLabel">
                                                                            <input type="checkbox" id="permission-{{$permission->id}}" class="permission-check permission-selected-{{str_replace('','-',$key)}}" name="permissions[]" value="{{$permission->id}}" {{in_array($permission->id, $user->permissions->pluck('id')->toArray()) ? 'checked' : ''}}>
                                                                            {{$permission->name}}
                                                                        </label>

                                                                    </div>
                                                                @empty

                                                                @endforelse

                                                            </roleset>
                                                        </div>
                                                    </div>

                                                @empty

                                                @endforelse
                                            </div>

                                        @endif

                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</section>
<!-- /.content -->
@endsection

@push('scripts')

<script>
let permission = [];

function roleGetPermission(){
    var role = $('#role').find('select').val();
    sendHttpRequest("/role-permissions", "POST", {role_id: role}, getData, isToShowLoader = true);
}

function getData(res) {
        console.log(res);

        if (res.is_success) {
            if (res.data.status) {
                permission = res.data.data;
                printPermission();
            } else {

            }
        }
    }

function onChangeClickCheckAll() {

    if($('#check-all').is(':checked')){
        $('.permission-group-check').prop('checked',true);
        $('.permission-check').prop('checked',true);
    }else{
        $('.permission-group-check').prop('checked',false);
        $('.permission-check').prop('checked',false);
    }

}

function selectSubGroup(key){
    if($(`#permission-group-id-${key}`).is(':checked')){
        $('.permission-selected-'+key).prop('checked',true)
    }else{
        $('.permission-selected-'+key).prop('checked',false)
        $('#check-all').prop('checked',false)
    }

}

function printPermission(){
    $('.permission-group-check').prop('checked',false);
    $('.permission-check').prop('checked',false);
    $.each(permission, function(key,value){
        $(`#permission-${value}`).prop('checked',true)
    });
}


</script>
@endpush
