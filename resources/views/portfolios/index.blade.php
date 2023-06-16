@extends('layouts.web')

@section('content')
    <h1 class="h3 mb-2 text-gray-800">Portofolio</h1>

    @if (session('success_message'))
        <div class="alert alert-success">
            {{ session('success_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="{{ route('portfolios.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i>&nbsp; Create Portofolio</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>URL</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->description }}</td>
                                <td>
                                    <a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#imageModal{{$item->id}}">
                                        <i class="far fa-eye fa-sm text-white-50"></i>&nbsp; View Image</a>
                                    </a>
                                    &nbsp;
                                    <a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" href="{{ URL::asset('/file/' . @$item->image_file_url) }}" download="{{ $item->image_file_url }}"
                                        class="tag">Download Image</a>
                                    <div class="modal fade" id="imageModal{{$item->id}}" tabindex="-1" role="dialog"
                                        aria-labelledby="imageModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="{{ URL::asset('/file/' . @$item->image_file_url) }}"
                                                        class="img-fluid" alt="Image Preview">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><a href="{{ $item->url }}" target="_blank">{{ $item->url }}</a></td>
                                <td>{{ $item->category->name }}</td>
                                <td>
                                    <a href="{{ route('portfolios.edit', $item->id) }}" class="btn btn-info">
                                        Edit
                                    </a>
                                    <form action="{{ route('portfolios.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger" onclick="return confirm('You sure want to delete {{ $item->title }}?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endsection
