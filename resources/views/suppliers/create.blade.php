@extends('layouts.main')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <ol class="d-flex breadcrumb bg-transparent p-0 justify-content-end">
            <li class="breadcrumb-item text-capitalize"><a href="/">Home</a></li>
            <li class="breadcrumb-item text-capitalize"><a href="{{route('suppliers.index')}}">Suppliers</a></li>
            <li class="breadcrumb-item text-capitalize active" aria-current="page">Add Supplier</li>
        </ol>
    </div>
</div>


<section class="content">
    <div class="container-fluid">
        <div class="container">
            <main class="mx-auto m-4">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card" style="width:80%;margin: auto">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 style="color:red;"> Add <small class="text-muted">Supplier</small></h4>
                                    </div>
                                    <div>
                                        <a href="{{route('suppliers.index')}}" class="btn btn-md btn-warning float-end">Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{route('suppliers.store')}}" method="POST">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                          <label for="name">Name</label>
                                          <input type="type" class="form-control @error('name') is-invalid @enderror" name="name"  id="name" placeholder="Supplier Name"  value="{{ old('name') }}">
                                          @error('name')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                          @enderror
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="phone_no">Phone No</label>
                                            <input type="type" class="form-control @error('phone_no') is-invalid @enderror" name="phone_no" id="phone_no" placeholder="Phone No"  value="{{ old('phone_no') }}">
                                            @error('phone_no')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Email"  value="{{ old('email') }}">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="address">Address</label>
                                            <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" placeholder="Address"  value="{{ old('address') }}"></textarea>
                                            @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
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

