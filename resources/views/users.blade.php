@extends('layouts.adminpanel')

@section('title', 'Manage Users Acccount')

@section('breadcrumb')
  <li class="list-inline-item">
      <a href="{{ route('dashboard') }}">Dashboard</a>
  </li>
  <li class="list-inline-item seprate">
      <span>/</span>
  </li>
  <li class="list-inline-item active">Manage Users Acccount</li>
@endsection

@section('pageheader', 'Manage Users Acccount')

@section('content')

  @if (session('deletestatus'))
      <br>
      <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
        <span class="badge badge-pill badge-success">Success</span>
        {{ session('deletestatus') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
  @endif

  <br>
  <div class="table-responsive m-b-30">
    <table class="table table-borderless table-data3" id="tableUsers">
        <thead>
            <tr>
                <th>ID.</th>
                <th>Avatar</th>
                <th>Name</th>
                <th>Username</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Country</th>
                <th>Bio</th>
                <th>Website</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
              <tr>
                  <td>{{ $user->id }}</td>
                  <td>
                    @if ($user->avatar_url != null)
                      <a href="{{ $user->avatar_url }}" data-lightbox="user{{ $user->id }}-pic" data-title="{{ $user->name }}">
                        <img src="{{ $user->avatar_url }}" width="150px">
                      </a>
                    @else
                      <img src="/images/icon/avatar.png" width="150px">
                    @endif
                  </td>
                  <td><a href="/userprofile/{{ $user->id }}" target="_blank">{{ $user->name }}</a></td>
                  <td>{{ $user->username }}</td>
                  <td>{{ $user->phone }}</td>
                  <td>{{ $user->address }}</td>
                  <td>{{ $user->country->name }}</td>
                  <td>{{ $user->bio }}</td>
                  <td>{{ $user->website }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->role }}</td>
                  <td>
                      <div class="table-data-feature">
                        <form id="delete-form" action="/users/delete" method="POST" onsubmit="return confirm('Do you really want to delete this user account?');">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <button type="submit" class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete User Account">
                                <i class="zmdi zmdi-delete"></i>
                            </buton>
                        </form>
                      </div>
                  </td>
              </tr>
            @endforeach
        </tbody>
    </table>
  </div>
@endsection

@push('scripts')
  <script>

    $(document).ready(function() {

        // DataTables
        var table = $('#tableUsers').DataTable( {
            dom: 'Bfrtilp',
            buttons: [
                'copy', 'excel', 'pdf',
            ],
            order: [
              [0,"desc"]
            ]
        });

    });
  </script>
@endpush
