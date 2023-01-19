@extends('layouts.admin')

@section('title', 'Add Users')

@section('content')
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Add group</h1>
  </div>

  @if ($errors->any())
    <div class="alert alert-danger text-center">Please input data, not empty data</div>
  @endif
  <form action="" method="POST">
    <div class="mb-3">
      <label for="name">Name</label>
      <input name="name" type="text" class="form-control" placeholder="Name..." value="{{ old('name') }}">
      @error('name')
        <span style="color:red">{{ $message }}</span>
      @enderror
    </div>
    <button type="submit" class="btn btn-primary">Add new</button>
    @csrf
  </form>
@endsection
