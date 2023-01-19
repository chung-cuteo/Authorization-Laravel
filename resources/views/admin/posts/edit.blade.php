@extends('layouts.admin')

@section('title', 'Edit post')

@section('content')
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit post</h1>
  </div>
  @if (session('msg'))
    <div class="alert alert-success">{{ session('msg') }}</div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger text-center">Please input data, not empty data</div>
  @endif
  <form action="" method="POST">
    <div class="mb-3">
      <label for="title">Title</label>
      <textarea name="title" class="form-control">{{ old('title') ?? $post->content }}</textarea>
      @error('title')
        <span style="color:red">{{ $message }}</span>
      @enderror
    </div>
    <div class="mb-3">
      <label for="content">Content</label>
      <textarea name="content" rows="10" class="form-control" placeholder="noi dung bai viet...">{{ old('content') ?? $post->content }}</textarea>
      @error('content')
        <span style="color:red">{{ $message }}</span>
      @enderror
    </div>


    <button type="submit" class="btn btn-primary">Update</button>
    @csrf
  </form>
@endsection
