@extends('layouts.main')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <ol class="d-flex breadcrumb bg-transparent p-0 justify-content-end">
            <li class="breadcrumb-item text-capitalize"><a href="/dashboard">Home</a></li>
            <li class="breadcrumb-item text-capitalize"><a href="#">Reports</a></li>
            <li class="breadcrumb-item text-capitalize active" aria-current="page">Reservation Reports</li>
        </ol>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="container">
            <main class="mx-auto m-4">

                <div class="row" id="filter-panel">
                    <div class="col-12">
                        <form action="{{route('reports.reservation')}}" method="GET">
                            <div class="my-3 p-3 bg-white rounded shadow-sm">
                                <div class="d-flex">
                                    <div class="col-12 col-md-8">
                                        <div class="mb-3">
                                            <label for="type" class="form-label">Type</label>
                                            <select class="form-control" name="type" id="type">
                                                <option value="MONTH" {{ $type == 'MONTH' ? 'selected' : "" }}>Month-wise</option>
                                                <option value="YEAR" {{ $type == 'YEAR' ? 'selected' : "" }}>Year-wise</option>
                                                <option value="CUSTOMER" {{ $type == 'CUSTOMER' ? 'selected' : "" }}>Customer-wise</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 mt-1">
                                        <div class="mt-4 mb-3">
                                            <button type="submit" class="btn btn-primary w-100 mx-1">SUBMIT</button>
                                        </div>
                                    </div>
                                    {{-- <div class="col-12 col-md-4">
                                        <div class="mb-3">
                                            <label for="from" class="form-label">From</label>
                                            <input type="date" class="form-control" name="from" id="from" value="{{$from != "" ? $from : date('Y-m-d')}}"/>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="mb-3">
                                            <label for="to" class="form-label">To</label>
                                            <input type="date" class="form-control" name="to" id="to" value="{{$to != "" ? $to : date('Y-m-d')}}"/>
                                        </div>
                                    </div> --}}
                                </div>
                                {{-- <div class="row border-top-1 m-0 pt-4 mt-2">
                                    <div class="col-12 col-md-3 offset-md-9 d-flex">
                                        <button type="submit" class="btn btn-primary w-100 mx-1">SUBMIT</button>
                                    </div>
                                </div> --}}
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6>Reservation Report</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-bordered border-primary">
                                    <thead>
                                    <tr>
                                    @if($type == "MONTH")
                                    <tr>
                                        <th class="width=25%">Month</th>
                                        {{-- <th class="width=25%">Reservation Count</th> --}}
                                        <th class="width=25%">Total Amount</th>
                                        <th class="width=25%">Total Received</th>
                                    </tr>
                                    @elseif($type == "YEAR")
                                    <tr>
                                        <th class="width=25%">Year</th>
                                        {{-- <th class="width=25%">Reservation Count</th> --}}
                                        <th class="width=25%">Total Amount</th>
                                        <th class="width=25%">Total Received</th>
                                    </tr>
                                    @elseif($type == "CUSTOMER")
                                    <tr>
                                        <th class="width=25%">Customer</th>
                                        <th class="width=25%">Quantity</th>
                                        <th class="width=25%">Total Amount (Received)</th>
                                    </tr>
                                    @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $value)
                                        @if($type == "MONTH")
                                        <tr>
                                            <td>
                                                <div>{{$value->date}}</div>
                                            </td>
                                            {{-- <td>
                                                <div>{{$value->reservation_count}}</div>
                                            </td> --}}
                                            <td class="cash-number">
                                                <div>{{number_format($value->payment_total,2)}}</div>
                                            </td>
                                            <td class="cash-number">
                                                <div>{{number_format($value->payment_total_received,2)}}</div>
                                            </td>
                                        </tr>

                                        @elseif($type == "YEAR")
                                        <tr>
                                            <td>
                                                <div>{{$value->date}}</div>
                                            </td>
                                            {{-- <td>
                                                <div>{{$value->reservation_count}}</div>
                                            </td> --}}
                                            <td class="cash-number">
                                                <div>{{number_format($value->payment_total,2)}}</div>
                                            </td>
                                            <td class="cash-number">
                                                <div>{{number_format($value->payment_total_received,2)}}</div>
                                            </td>
                                        </tr>
                                        </tr>
                                        @elseif($type == "CUSTOMER")
                                        <tr>
                                            <td id="td-customer">
                                                <div>{{$value->full_name}}</div>
                                            </td>
                                            <td class="cash-number">
                                                <div>{{$value->qty}}</div>
                                            </td>
                                            <td class="cash-number">
                                                <div>{{number_format($value->payment_total_received,2)}}</div>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="float-right">
                                    {{-- {{$data->links('pagination::bootstrap-4')}} --}}
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
