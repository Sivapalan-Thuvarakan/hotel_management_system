@extends('layouts.main')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <ol class="d-flex breadcrumb bg-transparent p-0 justify-content-end">
            <li class="breadcrumb-item text-capitalize"><a href="/">Home</a></li>
            <li class="breadcrumb-item text-capitalize"><a href="{{route('rooms.index')}}">Rooms</a></li>
            <li class="breadcrumb-item text-capitalize active" aria-current="page">View Room</li>
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
                                        <h4>View Room</h4>
                                    </div>
                                    <div>
                                        <a href="{{route('rooms.index')}}" class="btn btn-sm btn-warning float-end">Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-item">
                                    <table class="table-list-view">
                                        <tr>
                                        <td><strong>Code</strong></td>
                                        <td><strong>:</strong></td>
                                        <td>{{$room->code}}</td>
                                        </tr>
                                        <tr>
                                        <td><strong>Room Type</strong></td>
                                        <td><strong>:</strong></td>
                                        <td>{{$room->roomTypes->name}}</td>
                                        </tr>
                                        <tr>
                                        <td><strong>Rental Price</strong></td>
                                        <td><strong>:</strong></td>
                                        <td>{{$room->roomTypes->rental_price}}</td>
                                        </tr>
                                        <td><strong>Status</strong></td>
                                        <td><strong>:</strong></td>
                                        @if ($room->status == 'open')
                                        <td><span class="badge badge-secondary">Open</span></td>
                                        @else
                                        <td><span class="badge badge-success">Reserved</span></td>
                                        @endif
                                        </tr>
                                        <tr>
                                        <td><strong>Department</strong></td>
                                        <td><strong>:</strong></td>
                                        <td>{{$room->departments->name}}</td>
                                        </tr>
                                        <tr>
                                        <td><strong>Description</strong></td>
                                        <td><strong>:</strong></td>
                                        <td>{{$room->description}}</td>
                                        </tr>
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
