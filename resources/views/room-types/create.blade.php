@extends('layouts.main')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <ol class="d-flex breadcrumb bg-transparent p-0 justify-content-end">
            <li class="breadcrumb-item text-capitalize"><a href="/">Home</a></li>
            <li class="breadcrumb-item text-capitalize"><a href="{{route('room_types.index')}}">Room Types</a></li>
            <li class="breadcrumb-item text-capitalize active" aria-current="page">Add Room Type</li>
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
                                        <h4>Add New Room Type</h4>
                                    </div>
                                    <div>
                                        <a href="{{route('room_types.index')}}" class="btn btn-sm btn-warning float-end">Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{route('room_types.store')}}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    </div>
                                    <div class="mb-3">
                                    <label for="name" class="form-label">Rental Price</label>
                                    <input type="number" class="form-control @error('rental_price') is-invalid @enderror" id="rental_price" name="rental_price" value="{{ old('rental_price') }}">
                                    @error('rental_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    </div>
                                    <div class="mb-3">
                                    <label for="name" class="form-label">Reservation Fee Percentage</label>
                                    <input type="number" class="form-control @error('reservation_fee_percentage') is-invalid @enderror" id="reservation_fee_percentage" name="reservation_fee_percentage" value="{{ old('reservation_fee_percentage') }}">
                                    @error('reservation_fee_percentage')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea type="text" class="form-control" id="description" name="description" value="{{ old('description') }}"></textarea>
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

