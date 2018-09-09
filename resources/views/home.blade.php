@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
              <div class="card-header">
                <h4 class="text-center">Dashboard</h4>
                <ul class="nav nav-tabs card-header-tabs">
                  <li class="nav-item">
                    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Profile</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="itineraries-tab" data-toggle="tab" href="#itineraries" role="tab" aria-controls="itineraries" aria-selected="false">Itineraries</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="comments-tab" data-toggle="tab" href="#comments" role="tab" aria-controls="comments" aria-selected="false">Comments</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">

                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <p><img src="{{ $user->avatar_url }}" class="text-center"/><p>
                    <table class="table">
                      <tr>
                        <th>Name</th>
                        <td>{{ $user->name }}</td>
                      </tr>
                      <tr>
                        <th>Username</th>
                        <td>{{ $user->username }}</td>
                      </tr>
                      <tr>
                        <th>Phone</th>
                        <td>{{ $user->phone }}</td>
                      </tr>
                      <tr>
                        <th>Address</th>
                        <td>{{ $user->address }}</td>
                      </tr>
                      <tr>
                        <th>Country</th>
                        <td>{{ $user->country_name }}</td>
                      </tr>
                      <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                      </tr>
                      <tr>
                        <th>Date Registered</th>
                        <td>{{ $user->created_at }}</td>
                      </tr>
                    </table>

                </div>

                <div class="tab-pane fade show active" id="itineraries" role="tabpanel" aria-labelledby="itineraries-tab">

                </div>

                <div class="tab-pane fade show active" id="comments" role="tabpanel" aria-labelledby="comments-tab">

                </div>

              </div>
            </div>
        </div>
    </div>
</div>



@endsection
