@extends('layouts.main')
@include('includes.customer-add')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <ol class="d-flex breadcrumb bg-transparent p-0 justify-content-end">
            <li class="breadcrumb-item text-capitalize"><a href="/">Home</a></li>
            <li class="breadcrumb-item text-capitalize"><a href="{{route('reservations.index')}}">Reservations</a></li>
            <li class="breadcrumb-item text-capitalize active" aria-current="page">Add Reservation</li>
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
                                        <h4>Add New Reservation</h4>
                                    </div>
                                    <div>
                                        <a href="{{route('reservations.index')}}" class="btn btn-sm btn-warning float-end">Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{route('reservations.store')}}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <label for="name" class="form-label">Customer</label>
                                        <button type="button" class="btn btn-white btn-sm" data-toggle="modal"
                                        data-target="#customerAddModal">
                                        <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                            viewBox="0 0 12 16" height="1em" width="1em"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M12 9H7v5H5V9H0V7h5V2h2v5h5v2z"></path>
                                        </svg>
                                        Add Customer
                                        </button>
                                    </div>
                                    <select class="form-control customer-search  @error('customer_id') is-invalid @enderror" name="customer_id"
                                        id="customer_id"></select>
                                        @error('customer_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="from_date" class="form-label">Date From</label>
                                        <input type="date" class="form-control @error('from_date') is-invalid @enderror" id="from_date" name="from_date" value="{{ old('from_date',date('Y-m-d')) }}">
                                        @error('from_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="to_date" class="form-label">Date To</label>
                                        <input type="date" class="form-control @error('to_date') is-invalid @enderror" id="to_date" name="to_date" value="{{ old('to_date',date('Y-m-d')) }}">
                                        @error('to_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="room-type" class="form-label">Room Type </label>
                                            <select class="form-control room-type  @error('room_type_id') is-invalid @enderror" name="room_type_id"
                                            id="room_type_id">
                                            @foreach ($roomTypes as $item)
                                                <option value="{{$item->id}}">{{$item->name}} | {{$item->rental_price}} | {{$item->room_count}}</option>
                                            @endforeach
                                            </select>
                                            @error('room_type_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="room_id" class="form-label">Room</label>
                                            <select class="form-control  room-fetch @error('room_id') is-invalid @enderror" name="room_id"
                                            id="room_id"></select>
                                            <span class="invalid-feedback" id="room-alert" role="alert"> </span>
                                            @error('room_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end calc">
                                        <div type="botton" class="btn btn-primary" onclick="calculatePayment()"> Calculate Payment</div>
                                    </div>
                                    <div class="payments row">
                                        <div class="mb-3 col-md-6">
                                            <label for="total_fee" class="form-label">Total Room Fees</label>
                                            <input type="number" class="form-control @error('total_fee') is-invalid @enderror" id="total_fee" name="total_fee" disabled>
                                            @error('total_fee')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="reservation_fee" class="form-label">Reservation Fee</label>
                                            <input type="number" class="form-control @error('reservation_fee') is-invalid @enderror" id="reservation_fee" name="reservation_fee" disabled>
                                            @error('reservation_fee')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="hotel_payment" class="form-label">Hotel Payment</label>
                                            <input type="number" class="form-control @error('hotel_payment') is-invalid @enderror" id="hotel_payment" name="hotel_payment" value="{{ old('hotel_payment') }}">
                                            @error('hotel_payment')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="payment_received" class="form-label">Payment Received</label>
                                            <input type="number" class="form-control @error('payment_received') is-invalid @enderror" id="payment_received" name="payment_received" value="{{ old('payment_received') }}">
                                            @error('payment_received')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save Reservation</button>
                                        </div>
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
$('.customer-search').select2({
    placeholder: 'Select a customer',
    ajax: {
        url: "{{ route('customers.search') }}",
        dataType: 'json',
        processResults: function(data) {
            return {
                results: $.map(data, function(item) {
                    return {
                        text: item.full_name.concat(" | " , item.code, " | " , item.nic),
                        id: item.id
                    }
                })
            };
        },
        error: function(res) {
            console.log(res);
        },
        cache: true
    }
});


$(document).ready(function() {
    $('.payments').hide();
    let room_type_id=$('#room_type_id').val();
    var roomUrl = "{{Route('rooms.search',":id")}}";
    roomUrl = roomUrl.replace(':id', room_type_id);
    fetchRooms(roomUrl);
});
$(".room-type").change( function(e) {
    let room_type_id2 = $("#room_type_id").val();
    var roomUrl = "{{Route('rooms.search',":id")}}";
    roomUrl = roomUrl.replace(':id', room_type_id2);
    fetchRooms(roomUrl);
});

function fetchRooms(url){
$.ajax({
    url: url,
    type: 'GET',
    success: function(res) {
        $('.room-fetch').empty();
        $.each(res, function (i, item) {
            $('.room-fetch').append($('<option>', {
                value: item.id,
                text : item.code
            }));
        });
    }
});
}

function calculatePayment(){
    let room_id = $('#room_id').val();
    let room_type_id = $('#room_type_id').val();
    let from = $('#from_date').val();
    let to = $('#to_date').val();
    if(room_id == null){
        $('#room_id').addClass('is-invalid');
        $("#room-alert").html(`<strong> Room Cannot be empty. </strong>`);
        $('.payments').hide();
    } else {
        $('#room_id').removeClass('is-invalid');
        $("#room-alert").html(``);
    }
    let data = {
        _token: "{{ csrf_token() }}",
        room_type_id: room_type_id,
        room_id: room_id,
        from: from,
        to: to
    }
    if(data.room_id != null && data.room_type_id != null){
        $.ajax({
            url: "{{route('rooms.payment')}}",
            type: 'POST',
            data: data,
            success: function(res) {
                showValues(res)
            }
        });
    }
}

function showValues(data){
    console.log(data);
    $('#total_fee').val(data.data.totalRoomFee);
    $('#reservation_fee').val(data.data.reservationFee);
    $('.payments').show();
}


</script>
@endpush
