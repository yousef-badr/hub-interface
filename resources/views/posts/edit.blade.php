@extends('layouts.main')
@section('title','Edit Post')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Enter Post Your Information
                    </div>
                    <div class="card-body">
                        <form action="{{ route('posts.update', $post->id)}}" method="POST" >
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}">
                            </div>
                            <div class="form-group">
                                <label for="body">Create post</label>
                                <textarea class="form-control" id="body" name="body">{{ $post->body }}</textarea>
                            </div><br>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
