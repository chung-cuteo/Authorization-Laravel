@extends('layouts.admin')

@section('title', 'Post')

@section('content')
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Post</h1>
  </div>
  @if (session('msg'))
    <div class="alert alert-success">{{ session('msg') }}</div>
  @endif
  <a href="{{ route('admin.posts.add') }}" class="btn btn-primary mb-3">Add</a>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th width="5%">STT</th>
        <th>Tieu de</th>
        <th width="35%">Nguoi dang</th>
        <th width="5%">Edit</th>
        <th width="5%">Delete</th>
      </tr>
    </thead>
    <tbody>
      @if ($listPosts->count() > 0)
        @foreach ($listPosts as $key => $post)
          <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $post->title }}</td>
            <td>
              {{ !empty($post->postBy->name) ? $post->postBy->name : false }}
            </td>
            <td>
              <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-warning">Edit</a>
            </td>
            <td>
              <a onclick="return confirm('You are sure Delete ?')" href="{{ route('admin.posts.delete', $post) }}"
                class="btn btn-danger">Delete</a>
            </td>
          </tr>
        @endforeach
      @endif
    </tbody>
  </table>
@endsection
