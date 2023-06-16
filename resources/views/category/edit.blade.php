@extends('layouts.web')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Category</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            Edit Category #{{ $data->id }}
        </div>
        <div class="card-body">
            <form method="POST" action="{{ url('admin/categories/'.$data->id) }}">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter title..."
                        required value="{{$data->name}}">
                </div>
                <button class="btn btn-primary" type="submit">Submit</button>
                <a href="{{ url('admin/categories') }}" class="btn btn-danger">Back</a>
            </form>
        </div>
    </div>
@endsection
