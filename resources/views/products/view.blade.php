@extends('layouts.main')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <ol class="d-flex breadcrumb bg-transparent p-0 justify-content-end">
            <li class="breadcrumb-item text-capitalize"><a href="/">Home</a></li>
            <li class="breadcrumb-item text-capitalize"><a href="{{route('products.index')}}">Product</a></li>
            <li class="breadcrumb-item text-capitalize active" aria-current="page">View Product</li>
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
                                        <h4>View Product</h4>
                                    </div>
                                    <div>
                                        <a href="{{route('products.index')}}" class="btn btn-lg btn-warning float-end">Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-item">
                                    <table class="table-list-view">
                                        <tr>
                                        <td><strong>Product Name</strong></td>
                                        <td><strong>:</strong></td>
                                        <td>{{$product->product_name}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Product Code</strong></td>
                                            <td><strong>:</strong></td>
                                            <td>{{$product->code}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Type</strong></td>
                                            <td><strong>:</strong></td>
                                            <td>{{$stock->type}}</td>
                                        </tr>

                                        <tr>
                                            <td><strong>Purchase_Price</strong></td>
                                            <td><strong>:</strong></td>
                                            <td>{{$stock->purchase_price}}</td>
                                        </tr>

                                        <tr>
                                            <td><strong>Selling_Price</strong></td>
                                            <td><strong>:</strong></td>
                                            <td>{{$product->selling_price}}</td>
                                        </tr>

                                        <tr>
                                            <td><strong>Discount</strong></td>
                                            <td><strong>:</strong></td>
                                            <td>{{$product->discount}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Date</strong></td>
                                            <td><strong>:</strong></td>
                                            <td>{{$stock->created_at}}</td>
                                        </tr>
                                        <tr>
                                        <tr>
                                            <td><strong>Description</strong></td>
                                            <td><strong>:</strong></td>
                                            <td>{{$stock->description}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Quantity</strong></td>
                                            <td><strong>:</strong></td>
                                            <td>{{$stock->quantity}}</td>
                                        </tr>
                                        <tr>
                                    </table>
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
