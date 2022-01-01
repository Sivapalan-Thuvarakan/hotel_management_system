@extends('layouts.main')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <ol class="d-flex breadcrumb bg-transparent p-0 justify-content-end">
            <li class="breadcrumb-item text-capitalize"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item text-capitalize"><a href="{{route('departments.index')}}">Departments</a></li>
            <li class="breadcrumb-item text-capitalize active" aria-current="page">Add Department</li>
        </ol>
    </div>
</div>


<section class="content">
    <div class="container-fluid">
        <div class="container">
            <main class="mx-auto m-4">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>Add New Department</h4>
                                    </div>
                                    <div>
                                        <a href="{{route('departments.index')}}" class="btn btn-sm btn-warning float-end">Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{route('departments.store')}}" method="POST">
                                    @csrf

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="mb-3">
                                                <label for="contact_no" class="form-label">Contact No</label>
                                                <input type="number" class="form-control @error('contact_no') is-invalid @enderror" id="contact_no" name="contact_no" value="{{ old('contact_no') }}">
                                                @error('contact_no')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        @can('can-view-main-department')
                                        <div class="col-lg-6 col-md-6">
                                            <div class="mb-3 mt-3 ml-3">
                                                <input type="checkbox" id="is_sub" name="is_sub">
                                                <label class="form-label" for="is_sub">
                                                    Sub Department
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="mb-3  sub_dep">
                                                <label for="parent_id" class="form-label">Main Department</label>
                                                <select class="form-control" name="parent_id">
                                                    @foreach ($main_departments as $main_department)
                                                        <option value="{{$main_department->id}}" {{old('parent_id') == $main_department->id ? 'selected' : ''}}>{{$main_department->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @endcan
                                        <div class="col-lg-6 col-md-6">
                                            <div class="mb-3">
                                                <label for="address" class="form-label">Address</label>
                                                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="mb-3">
                                                <label for="admin_id" class="form-label">Admin</label>
                                                <select class="form-control @error('admin_id') is-invalid @enderror" name="admin_id">
                                                    @foreach ($admins as $admin_id)
                                                        <option value="{{$admin_id->id}}" {{old('admin_id') == $admin_id->id ? 'selected' : ''}}>{{$admin_id->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('admin_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> save</button>
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

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.sub_dep').hide();
});


$("#is_sub").change(function() {
    if(this.checked) {
        $('.sub_dep').show();
    }
    if(!this.checked){
        $('.sub_dep').hide();
    }
});
</script>
@endpush
