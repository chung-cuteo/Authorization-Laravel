@extends('layouts.admin')

@section('title', 'List Groups')

@section('content')
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">List groups user</h1>
  </div>
  @if (session('msg'))
    <div class="alert alert-success">{{ session('msg') }}</div>
  @endif
  <a href="{{ route('admin.groups.add') }}" class="btn btn-primary mb-3">Add</a>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th width="5%">STT</th>
        <th>Name</th>
        <th width="35%">User add</th>
        <th width="20%">Role</th>
        <th width="5%">Edit</th>
        <th width="5%">Delete</th>
      </tr>
    </thead>
    <tbody>
      @if ($listGroups->count() > 0)
        @foreach ($listGroups as $key => $group)
          <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $group->name }}</td>
            <td>
              {{ !empty($group->postBy->name) ? $group->postBy->name : false }}
            </td>
            <td>
              <a href="{{ route('admin.groups.permission', $group) }}" class="btn btn-primary">Phân Quyền</a>
            </td>
            <td>
              <a href="{{ route('admin.groups.edit', $group) }}" class="btn btn-warning">Edit</a>
            </td>
            <td>
              <a onclick="return confirm('You are sure Delete ?')" href="{{ route('admin.groups.delete', $group) }}"
                class="btn btn-danger">Delete</a>
            </td>
          </tr>
        @endforeach
      @endif
    </tbody>
  </table>
@endsection
