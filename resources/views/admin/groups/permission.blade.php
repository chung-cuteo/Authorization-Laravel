@extends('layouts.admin')

@section('title', 'Phân Quyền')

@section('content')
  <h2 class="mb-4">phan quyen nhom: Mnager</h2>
  @if (session('msg'))
    <div class="alert alert-success">{{ session('msg') }}</div>
  @endif
  <form action="" method="POST">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th width="20%">Module</th>
          <th>Quyền</th>
        </tr>
      </thead>

      <tbody>

        @if ($modules->count() > 0)
          @foreach ($modules as $module)
            <tr>
              <td>{{ $module->title }}</td>
              <td>
                @php
                  $roles = [
                      'view' => 'xem',
                      'add' => 'Thêm',
                      'edit' => 'Sửa',
                      'delete' => 'Xoá',
                  ];
                @endphp
                <div class="row">
                  @if (!empty($roles))
                    @foreach ($roles as $key => $role)
                      <div class="col-2">
                        <label for="role_{{ $module->name }}_{{ $key }}">
                          <input type="checkbox" name="role[{{ $module->name }}][]"
                            id="role_{{ $module->name }}_{{ $key }}" value="{{ $key }}"
                            {{ isRole($roleArr, $module->name, $key) ? 'checked' : false }}>
                          {{ $role }}
                        </label>
                      </div>
                    @endforeach
                  @endif

                  @if ($module->name === 'groups')
                    <div class="col-2">
                      <label for="role_{{ $module->name }}_permission">
                        <input type="checkbox" name="role[{{ $module->name }}][]"
                          id="role_{{ $module->name }}_permission" value="permission"
                          {{ isRole($roleArr, $module->name, 'permission') ? 'checked' : false }}>
                        Phân quyền
                      </label>
                    </div>
                  @endif
                </div>
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
    <button type="submit" class="btn btn-primary mt-3">Phân Quyền</button>
    @csrf
  </form>
@endsection
