@extends('layouts.web')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Portofolio</h1>

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
            Edit Portofolio #{{ $data->id }}
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('portfolios.update', $data->id) }}" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" value="{{ $data->title }}" class="form-control" id="title"
                        placeholder="Enter title..." required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" id="description" cols="30" rows="3"
                        placeholder="Enter description..." required>{{ $data->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="image_url">Image</label>
                    <input name="image_url" type="file" value="{{ $data->image_file_url }}" class="form-control"
                        id="image_url">
                </div>
                <div class="form-group">
                    <label for="url">URL</label>
                    <input type="text" name="url" class="form-control" value="{{ $data->url }}" id="url"
                        placeholder="Enter URL..." required>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category_id" class="form-control" id="category_id" required>
                        @foreach ($categories as $category)
                            @if ($category->id == $data->category_id)
                                <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                            @else
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-primary" type="submit">Update</button>
                <a href="{{ route('portfolios.index') }}" class="btn btn-danger">Back</a>
            </form>
        </div>
    </div>
@endsection
