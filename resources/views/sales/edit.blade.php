@extends('layouts.main')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <ol class="d-flex breadcrumb bg-transparent p-0 justify-content-end">
            <li class="breadcrumb-item text-capitalize"><a href="/">Home</a></li>
            <li class="breadcrumb-item text-capitalize"><a href="{{route('reservations.index')}}">Reservations</a></li>
            <li class="breadcrumb-item text-capitalize active" aria-current="page">Handle Reservation</li>
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
                                        <h4>Handle Reservation</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{route('reservations.update',$roomReservation->id)}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label for="name" class="form-label">Total Fee</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name',$roomReservation->total_payable) }}" disabled>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="name" class="form-label">Paid Amount</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name',$amountPaid) }}" disabled>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="name" class="form-label">Balance To Be Paid</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name',$toBePaid) }}" disabled>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="amount_received" class="form-label">Amount Received</label>
                                            <input type="text" class="form-control @error('amount_received') is-invalid @enderror" id="amount_received" name="amount_received" value="{{ old('amount_received') }}" >
                                            @error('amount_received')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
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

