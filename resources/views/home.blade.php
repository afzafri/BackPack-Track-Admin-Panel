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
                <div class="tab-content pl-3 p-1" id="myTabContent">
                  <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                      @if($user->avatar_url != null || $user->avatar_url != "")
                        <p class="text-center"><img src="{{ $user->avatar_url }}" width="150px" class="img-thumbnail"/><p>
                      @endif
                      @if($user->bio != null || $user->bio != "")
                        <p><i>{{ $user->bio }}</i></p>
                      @endif
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
                        @if($user->website != null || $user->website != "")
                          <tr>
                            <th>Website</th>
                            <td><a href="{{ $user->website }}">{{ $user->website }}</a></td>
                          </tr>
                        @endif
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

                  <div class="tab-pane fade" id="itineraries" role="tabpanel" aria-labelledby="itineraries-tab">
                    <div class="table-responsive m-b-30">
                      <table class="table table-striped" id="tableItineraries">
                          <thead>
                              <tr>
                                  <th>ID.</th>
                                  <th>User</th>
                                  <th>Country</th>
                                  <th>Trip Title</th>
                                  <th>Duration</th>
                                  <th>Likes</th>
                                  <th>Comments</th>
                                  <th>Total Budget</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach ($itineraries as $itinerary)
                                <tr>
                                    <td>{{ $itinerary->id }}</td>
                                    <td>{{ $itinerary->user->name }}</td>
                                    <td>{{ $itinerary->country->name }}</td>
                                    <td>
                                      <a href="/itinerary/{{ $itinerary->id }}" target="_blank" class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Activities">
                                          {{ $itinerary->title }}
                                      </a>
                                    </td>
                                    <td>{{ $itinerary->duration }}</td>
                                    <td>{{ $itinerary->totallikes }}</td>
                                    <td>{{ $itinerary->totalcomments }}</td>
                                    <td>{{ $itinerary->country->currency }} {{ $itinerary->totalbudget }}</td>
                              @endforeach
                          </tbody>
                      </table>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="comments-tab">
                    <div class="table-responsive m-b-30">
                      <table class="table table-striped" id="tableComments">
                        <thead>
                            <tr>
                                <th>ID.</th>
                                <th>Commenter</th>
                                <th>Email</th>
                                <th>Comment</th>
                                <th>Date Time</th>
                                <th>Itinerary Title</th>
                                <th>Itinerary Owner</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($comments as $comment)
                              <tr>
                                  <td>{{ $comment->id }}</td>
                                  <td>{{ $comment->user->name }}</td>
                                  <td>{{ $comment->user->email }}</td>
                                  <td>{{ $comment->message }}</td>
                                  <td>{{ $comment->created_at }}</td>
                                  <td>{{ $comment->itinerary->title }}</td>
                                  <td>{{ $comment->itinerary->user->name }}</td>
                              </tr>
                            @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
  <script>

    $(document).ready(function() {
        $.noConflict();
        // DataTables
        $('#tableItineraries, #tableComments').DataTable();
    });
  </script>
@endpush
