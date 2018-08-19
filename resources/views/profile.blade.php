@extends('layouts.adminpanel')

@section('title', 'User Profile')

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
                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $user->name }}">

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
          <div class="card-header">Profile Picture</div>
      <form action="/profile/avatar" method="post" onsubmit="return confirm('Do you really want to update your profile picture?');" enctype="multipart/form-data">
          @csrf
          <div class="card-body card-block">
                <label class="form-control-label">Current profile picture</label><br>
                <img src="{{ $user->avatar_url }}" width="150px"/><br><br>

                <div class="row form-group">
                    <div class="col col-md-2">
                        <label class="form-control-label">Choose new profile picture</label>
                    </div>
                    <div class="col-12 col-md-10">
                        <input type="file" name="avatar" class="form-control-file">
                    </div>

                    @if ($errors->has('avatar'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('avatar') }}</strong>
                        </span>
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
