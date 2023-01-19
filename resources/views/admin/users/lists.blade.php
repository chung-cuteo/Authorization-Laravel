@extends('layouts.admin')

@section('title', 'List Users')

@section('content')
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">List Users</h1>
  </div>
  @if (session('msg'))
    <div class="alert alert-success">{{ session('msg') }}</div>
  @endif
  <a href="{{ route('admin.users.add') }}" class="btn btn-primary mb-3">Add</a>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th width="5%">STT</th>
        <th>Name</th>
        <th>Email</th>
        <th>Group</th>
        <th width="5%">Edit</th>
        <th width="5%">Delete</th>
      </tr>
    </thead>
    <tbody>
      @if ($listUsers->count() > 0)
        @foreach ($listUsers as $key => $user)
          <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->group->name }}</td>
            <td>
              <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">Edit</a>
            </td>
            <td>
              @if (Auth::user()->id !== $user->id)
                <a onclick="return confirm('You are sure Delete ?')" href="{{ route('admin.users.delete', $user) }}"
                  class="btn btn-danger">Delete</a>
              @endif
            </td>
          </tr>
        @endforeach
      @endif
    </tbody>
  </table>
@endsection
