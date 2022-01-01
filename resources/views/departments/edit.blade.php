@extends('layouts.main')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <ol class="d-flex breadcrumb bg-transparent p-0 justify-content-end">
            <li class="breadcrumb-item text-capitalize"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item text-capitalize"><a href="{{route('departments.index')}}">Departments</a></li>
            <li class="breadcrumb-item text-capitalize active" aria-current="page">Update Department</li>
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
                                        <h4>Update Department</h4>
                                    </div>
                                    <div>
                                        <a href="{{route('departments.index')}}" class="btn btn-sm btn-warning float-end">Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{route('departments.update',$department->id)}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name',$department->name) }}">
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
                                                <input type="number" class="form-control @error('contact_no') is-invalid @enderror" id="contact_no" name="contact_no" value="{{ old('contact_no',$department->contact_no) }}">
                                                @error('contact_no')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="mb-3">
                                                <label for="address" class="form-label">Address</label>
                                                <input type="text" class="form-control" id="address" name="address" value="{{ old('address',$department->address) }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="mb-3">
                                                <label for="admin_id" class="form-label">Admin</label>
                                                <select class="form-control @error('admin_id') is-invalid @enderror" name="admin_id">
                                                    <option value="{{$department->admin->id}}">{{$department->admin->name}}</option>
                                                    @foreach ($admins as $admin_id)
                                                        <option value="{{$admin_id->id}}" {{ old('admin_id') == '' ? ($department->admin->id == $admin_id->id ? 'selected' : '') : (old('admin_id') == $admin_id->id ? 'selected' : '') }}>{{$admin_id->name}}</option>
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

