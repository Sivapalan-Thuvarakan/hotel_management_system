@extends('layouts.main')
@include('includes.customer-add')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <ol class="d-flex breadcrumb bg-transparent p-0 justify-content-end">
            <li class="breadcrumb-item text-capitalize"><a href="/">Home</a></li>
            <li class="breadcrumb-item text-capitalize"><a href="{{route('sales.index')}}">Sales</a></li>
            <li class="breadcrumb-item text-capitalize active" aria-current="page">Add Sales</li>
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
                                        <h4>Add New Sale</h4>
                                    </div>
                                    <div>
                                        <a href="{{route('sales.index')}}" class="btn btn-sm btn-warning float-end">Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{route('sales.store')}}" method="POST">
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
                              
                           {{-- product --}}

                           <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <label for="name" class="form-label">Product</label>
                            </div>
                            <select class="form-control product-search  @error('product_id') is-invalid @enderror" name="product_id"
                                id="product_id"></select>
                                @error('product_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" id="quantity" placeholder="Quantity"  value="{{ old('quantity') }}">
                                <span class="invalid-feedback" id="quantity-alert" role="alert"> </span>
                                @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                                    <div class="d-flex justify-content-end calc">
                                        <div type="button" class="btn btn-primary" onclick="calculatePayment()"> Calculate Payment</div>
                                    </div>
                                    <div class="payments row">
                                        <div class="mb-3 col-md-6">
                                            <label for="discount_price" class="form-label">Discount Price(1 unit)</label>
                                            <input type="number" class="form-control @error('discount_price') is-invalid @enderror" id="discount_price" name="discount_price" readonly>
                                            @error('discount_price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="discount" class="form-label">Discount per unit</label>
                                            <input type="number" class="form-control @error('discount') is-invalid @enderror" id="discount" name="discount" disabled>
                                            @error('discount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="payments row">
                                        <div class="mb-3 col-md-6">
                                            <label for="total_bill" class="form-label">Total Bill</label>
                                            <input type="number" class="form-control @error('total_bill') is-invalid @enderror" id="total_bill" name="total_bill" disabled>
                                            @error('total_bill')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Create Payment</button>
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

$('.product-search').select2({
    placeholder: 'Select a Product',
    ajax: {
        url: "{{ route('products.search') }}",
        dataType: 'json',
        processResults: function(data) {
            return {
                results: $.map(data, function(item) {
                    return {
                        text: item.product_name.concat(" | " , item.code, " | price:LKR",item.selling_price, " | discount : ",item.discount,"%"),
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
});

function calculatePayment(){
    let product_id = $('#product_id').val();
    let quantity = $('#quantity').val();
    if(quantity == null){
        $('#quantity').addClass('is-invalid');
        $("#quantity-alert").html(`<strong> Quantity Cannot be empty. </strong>`);
        $('.payments').hide();
    } else {
        $('#quantity').removeClass('is-invalid');
        $("#quantity-alert").html(``);
    }
    let data = {
        _token: "{{ csrf_token() }}",
        product_id: product_id,
        quantity: quantity,
    }
    if(data.product_id != null && data.quantity != null){
        $.ajax({
            url: "{{route('sales.payment')}}",
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
    $('#total_bill').val(data.data.total_bill);
    $('#discount_price').val(data.data.discount_price);
    $('#discount').val(data.data.discount);
    $('.payments').show();
}


</script>
@endpush
