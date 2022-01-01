@extends('layouts.main')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <ol class="d-flex breadcrumb bg-transparent p-0 justify-content-end">
            <li class="breadcrumb-item text-capitalize"><a href="/">Home</a></li>
            <li class="breadcrumb-item text-capitalize"><a href="{{route('rooms.index')}}">Rooms</a></li>
            <li class="breadcrumb-item text-capitalize active" aria-current="page">Update Room</li>
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
                                    <div>
                                        <h4>Update Room</h4>
                                    </div>
                                    <div>
                                        <a href="{{route('rooms.index')}}" class="btn btn-sm btn-warning float-end">Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{route('rooms.update',$room->id)}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                    <label for="room_type_id" class="form-label">Room Type </label>
                                    <select type="text" class="form-control @error('room_type_id') is-invalid @enderror" id="room_type_id" name="room_type_id" value="{{ old('room_type_id') }}">
                                        @foreach ($roomTypes as $item)
                                        <option value="{{$item->id}}" {{ old('room_type_id') == '' ? ($room->room_type_id== $item->id ? 'selected' : '') : (old('room_type_id') == $item->id ? 'selected' : '') }}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('room_type_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <input type="text" class="form-control" id="description" name="description" value="{{ old('description',$room->description)}}">
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

