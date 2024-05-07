@extends('layouts.main')
@section('title','Show Posts')
@section('content')
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Post</th>
            <th>Writer</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            @if(!$post->hidden)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->body }}</td>
                <td>{{ $post->user->name }}</td>
                <td>
                    <a href="{{ route('posts.edit', $post->id) }}"><button type="button" class="btn btn-primary">Edit</button></a>
                    <button type="button" onclick="hidePost({{ $post->id }})" class="btn btn-warning">Hide</button>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="post" style="display: inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Soft Delete</button>
                    </form>
                </td>
            </tr>
            @endif
    @endforeach

<script>
    function hidePost(postId) {
        fetch(`/posts/${postId}/hide`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            document.getElementById(`post-${postId}`).style.display = 'none';
            console.log(data.message);
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
    }
</script>
@endsection
