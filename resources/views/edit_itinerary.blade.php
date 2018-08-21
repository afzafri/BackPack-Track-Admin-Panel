@extends('layouts.adminpanel')

@section('title', 'Edit Itinerary')

@section('breadcrumb')
  <li class="list-inline-item">
      <a href="{{ route('dashboard') }}">Dashboard</a>
  </li>
  <li class="list-inline-item seprate">
      <span>/</span>
  </li>
  <li class="list-inline-item">
      <a href="{{ route('itineraries') }}">Itineraries</a>
  </li>
  <li class="list-inline-item seprate">
      <span>/</span>
  </li>
  <li class="list-inline-item active">Itinerary ID:{{ $itinerary->id }}</li>
@endsection

@section('pageheader', 'Edit Itinerary')

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
      <form action="/itineraries/{{ $itinerary->id }}/edit" method="post" onsubmit="return confirm('Do you really want to update this itinerary?');">
          @csrf
          <div class="card-body card-block">
                <div class="form-group">
                    <label class="form-control-label">Title</label>
                    <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ $itinerary->title }}" required>

                    @if ($errors->has('title'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label>Country</label>
                    <select id="country_id" class="form-control{{ $errors->has('country_id') ? ' is-invalid' : '' }}" name="country_id" required>
                      <option value="">Choose country</option>
                        @foreach ($countries as $country)
                          @if ($itinerary->country->id == $country['id'])
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
                    <label class="form-control-label">User</label>
                    <input type="text" class="form-control" value="{{ $itinerary->user->name }}" disabled>
                </div>
                <input type="hidden" name="itinerary_id" value="{{ $itinerary->id }}">
                <input type="hidden" name="user_id" value="{{ $itinerary->user->id }}">
          </div>
          <div class="card-footer">
              <button type="submit" class="btn btn-primary btn-sm">
                  <i class="fa fa-save"></i> Update
              </button>
          </div>
      </form>
  </div>
@endsection
