@extends('layouts.main')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <ol class="d-flex breadcrumb bg-transparent p-0 justify-content-end">
            <li class="breadcrumb-item text-capitalize"><a href="/">Home</a></li>
            <li class="breadcrumb-item text-capitalize"><a href="{{route('stocks.index')}}">Stocks</a></li>
            <li class="breadcrumb-item text-capitalize active" aria-current="page">Update Stock</li>
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
                                        <h4 style="color:red;"> Update <small class="text-muted">Stock</small></h4>
                                    </div>
                                    <div>
                                        <a href="{{route('stocks.index')}}" class="btn btn-md btn-warning float-end">Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{route('stocks.update',$stock->id)}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                          <label for="product_name">Product Name</label>
                                          <input type="type" class="form-control @error('product_name') is-invalid @enderror" name="product_name"  id="product_name" placeholder="Product Name"  value="{{ old('product_name',$stock->product_name) }}">
                                          @error('product_name')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                          @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="brand">Brand</label>
                                            <input type="type" class="form-control @error('brand') is-invalid @enderror" name="brand" id="brand" placeholder="Brand"  value="{{ old('brand',$stock->brand) }}">
                                            @error('brand')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                          <label for="type">Type </label>
                                          <input type="type" class="form-control @error('type') is-invalid @enderror" name="type" id="type" placeholder="Type"  value="{{ old('type',$stock->type) }}">
                                          @error('type')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                          @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="description">Description</label>
                                            <input type="type" class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="Description"  value="{{ old('description',$stock->description) }}">
                                            @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                          <label for="purchase_price">Purchase Price</label>
                                          <input type="number" class="form-control @error('purchase_price') is-invalid @enderror" name="purchase_price" id="purchase_price" placeholder="purchase price"  value="{{ old('purchase_price',$stock->purchase_price) }}">
                                          @error('purchase_price')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                          @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="quantity">Quantity</label>
                                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" id="quantity" placeholder="Quantity"  value="{{ old('quantity',$stock->quantity) }}">
                                            @error('quantity')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <div>
                                                <div class="form-group">
                                                    <label for="supplier">Supplier</label>
                                                    <select class="form-control" id="supplier" name="supplier">
                                                        @foreach ($suppliers as $supplier )
                                                            <option value={{ $supplier->id }} @if ($stock->supplier_id == $supplier->id)
                                                                selected
                                                            @endif>{{ $supplier ->name }}</option>
                                                        @endforeach
                                                    </select>
                                                  </div>
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

