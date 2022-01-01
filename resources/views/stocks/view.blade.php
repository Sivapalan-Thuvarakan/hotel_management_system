@extends('layouts.main')
@include('includes.product-add')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <ol class="d-flex breadcrumb bg-transparent p-0 justify-content-end">
            <li class="breadcrumb-item text-capitalize"><a href="/">Home</a></li>
            <li class="breadcrumb-item text-capitalize"><a href="{{route('stocks.index')}}">Stock</a></li>
            <li class="breadcrumb-item text-capitalize active" aria-current="page">View Stock</li>
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
                                        <h4>View Stock</h4>
                                    </div>
                                    <div>
                                        <a href="{{route('stocks.index')}}" class="btn btn-lg btn-warning float-end">Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-item">
                                    <table class="table-list-view">
                                        <tr>
                                        <td><strong>Product Name</strong></td>
                                        <td><strong>:</strong></td>
                                        <td>{{$stock->product_name}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Stock Code</strong></td>
                                            <td><strong>:</strong></td>
                                            <td>{{$stock->code}}</td>
                                            </tr>
                                        <tr>
                                        <tr>
                                            <td><strong>Brand</strong></td>
                                            <td><strong>:</strong></td>
                                            <td>{{$stock->brand}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Product Type</strong></td>
                                            <td><strong>:</strong></td>
                                            <td>{{$stock->type}}</td>
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
                                            <td><strong>purchase price</strong></td>
                                            <td><strong>:</strong></td>
                                            <td>{{$stock->purchase_price}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Quantity</strong></td>
                                            <td><strong>:</strong></td>
                                            <td>{{$stock->quantity}}</td>
                                        </tr>
                                        <tr>
                                    </table>
                                    <div class="d-flex justify-content-end">
                                        <a href="" class="btn btn-md btn-success" data-toggle="modal" data-target="#productAddModal"><i
                                            class="fas fa-dollar-sign"></i> Add price</a>
                                    </div>
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
