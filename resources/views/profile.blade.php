@extends('layouts.adminpanel')

@section('title', 'User Profile')

@section('breadcrumb')
  <li class="list-inline-item">
      <a href="{{ route('dashboard') }}">Dashboard</a>
  </li>
  <li class="list-inline-item seprate">
      <span>/</span>
  </li>
  <li class="list-inline-item active">User Profile</li>
@endsection

@section('pageheader', 'User Profile')

@section('content')

  @if (session('success'))
      <br>
      <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
        <span class="badge badge-pill badge-success">Success</span>
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
  @endif

  <br>
  <div class="card">
          <div class="card-header">Account</div>
      <form action="/profile" method="post" onsubmit="return confirm('Do you really want to update your account?');">
          @csrf
          <div class="card-body card-block">
                <div class="form-group">
                    <label class="form-control-label">ID</label>
                    <input type="text" class="form-control" value="{{ $user->id }}" disabled>
                </div>
                <div class="form-group">
                    <label class="form-control-label">Name</label>
                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $user->name }}" required>

                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="form-control-label">Username</label>
                    <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ $user->username }}" required>

                    @if ($errors->has('username'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="form-control-label">Phone</label>
                    <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ $user->phone }}" required>

                    @if ($errors->has('phone'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="form-control-label">Address</label>
                    <textarea id="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" required>{{ $user->address }}</textarea>

                    @if ($errors->has('address'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>Country</label>
                    <select id="country_id" class="form-control{{ $errors->has('country_id') ? ' is-invalid' : '' }}" name="country_id" required>
                      <option value="">Choose country</option>
                        @foreach ($countries as $country)
                          @if ($user->country_id == $country['id'])
                              <option value="{{ $country['id'] }}" selected>{{ $country['name'] }}</option>
                          @else
                              <option value="{{ $country['id'] }}">{{ $country['name'] }}</option>
                          @endif
                        @endforeach
                    </select>

                    @if ($errors->has('country_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('country_id') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="form-control-label">Bio</label>
                    <textarea id="bio" class="form-control{{ $errors->has('bio') ? ' is-invalid' : '' }}" name="bio">{{ $user->bio }}</textarea>

                    @if ($errors->has('bio'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('bio') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="form-control-label">Website</label>
                    <input id="website" type="text" class="form-control{{ $errors->has('website') ? ' is-invalid' : '' }}" name="website" value="{{ $user->website }}">

                    @if ($errors->has('website'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('website') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="form-control-label">Email</label>
                    <textarea id="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" required>{{ $user->email }}</textarea>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
          </div>
          <div class="card-footer">
              <button type="submit" class="btn btn-primary btn-sm">
                  <i class="fa fa-save"></i> Update
              </button>
          </div>
      </form>
  </div>

  <br>
  <div class="card">
          <div class="card-header">Change Password</div>
      <form action="/profile/password" method="post" onsubmit="return confirm('Do you really want to change your password?');">
          @csrf
          <div class="card-body card-block">
                <div class="form-group">
                    <label class="form-control-label">Old Password</label>
                    <input id="old_password" type="password" class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" name="old_password" required>

                    @if ($errors->has('old_password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('old_password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="form-control-label">New Password</label>
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="form-control-label">Confirm New Password</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
          </div>
          <div class="card-footer">
              <button type="submit" class="btn btn-primary btn-sm">
                  <i class="fa fa-save"></i> Change password
              </button>
          </div>
      </form>
  </div>

  <br>
  <div class="card">
          <div class="card-header">Profile Picture</div>
      <form action="/profile/avatar" method="post" onsubmit="return confirm('Do you really want to update your profile picture?');" enctype="multipart/form-data">
          @csrf
          <div class="card-body card-block">
                <label class="form-control-label" id="avatar_label">Current profile picture</label><br>
                <img src="{{ $user->avatar_url }}" width="150px" id="preview_avatar"/><br><br>

                <div class="form-group col-4">
                    <input type="file" name="avatar" id="avatar" class="form-control-file {{ $errors->has('avatar') ? ' is-invalid' : '' }}">

                    @if ($errors->has('avatar'))
                        <div class="alert alert-danger" role="alert">
                            <strong>{{ $errors->first('avatar') }}</strong>
                        </div>
                    @endif
                </div>
          </div>
          <div class="card-footer">
              <button type="submit" class="btn btn-primary btn-sm">
                  <i class="fa fa-upload"></i> Upload
              </button>
          </div>
      </form>
  </div>
  <br>

@endsection

@push('scripts')
  <script>
  $("#avatar").fileinput({
    theme: 'fa',
    dropZoneEnabled: false,
    showUpload: false,
    allowedFileExtensions: ['png','jpg','jpeg'],
    maxFileSize: 5000,
    msgPlaceholder: 'Choose new profile picture...',
  });
  </script>
@endpush
