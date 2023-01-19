@extends('layouts.admin')

@section('title', 'Add Users')

@section('content')
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Add Users</h1>
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

    <div class="mb-3">
      <label for="email">Email</label>
      <input name="email" type="text" class="form-control" placeholder="Email..." value="{{ old('email') }}">
      @error('email')
        <span style="color:red">{{ $message }}</span>
      @enderror
    </div>

    <div class="mb-3">
      <label for="password">Password</label>
      <input name="password" type="text" class="form-control" placeholder="Password...">
      @error('password')
        <span style="color:red">{{ $message }}</span>
      @enderror
    </div>

    <div class="mb-3">
      <label for="group">Group</label>
      <select name="group" class="form-control">
        <option value="0">Please select group</option>
        @if ($groups->count() > 0)
          @foreach ($groups as $group)
            <option value="{{ $group->id }}" {{ old('group') == $group->id ? 'selected' : false }}>{{ $group->name }}
            </option>
          @endforeach
        @endif
      </select>
      @error('group')
        <span style="color:red">{{ $message }}</span>
      @enderror
    </div>

    <button type="submit" class="btn btn-primary">Add new</button>
    @csrf
  </form>
@endsection
