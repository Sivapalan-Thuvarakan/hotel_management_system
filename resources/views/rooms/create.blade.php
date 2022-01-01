@extends('layouts.main')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <ol class="d-flex breadcrumb bg-transparent p-0 justify-content-end">
            <li class="breadcrumb-item text-capitalize"><a href="/">Home</a></li>
            <li class="breadcrumb-item text-capitalize"><a href="{{route('rooms.index')}}">Rooms</a></li>
            <li class="breadcrumb-item text-capitalize active" aria-current="page">Add Room</li>
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
                                        <h4>Add New Room</h4>
                                    </div>
                                    <div>
                                        <a href="{{route('rooms.index')}}" class="btn btn-sm btn-warning float-end">Back</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form action="{{route('rooms.store')}}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                    <label for="room_type_id" class="form-label">Room Type </label>
                                    <select type="text" class="form-control @error('room_type_id') is-invalid @enderror" id="room_type_id" name="room_type_id" value="{{ old('room_type_id') }}">
                                        @foreach ($roomTypes as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('room_type_id')
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

