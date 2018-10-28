@extends('layouts.app')

@section('title')
  {{ $user->name }} ({{ "@".$user->username }})
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
              <div class="card-header">
                <h4 class="text-center">{{ $user->name }}</h4>
                <ul class="nav nav-tabs card-header-tabs">
                  <li class="nav-item">
                    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Profile</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="itineraries-tab" data-toggle="tab" href="#itineraries" role="tab" aria-controls="itineraries" aria-selected="false">Itineraries</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content pl-3 p-1" id="myTabContent">
                  <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                      @if($user->avatar_url != null || $user->avatar_url != "")
                        <p class="text-center">
                          <a href="{{ $user->avatar_url }}" data-lightbox="{{ $user->id }}" data-title="{{ $user->name }} ({{ "@".$user->username }})">
                            <img src="{{ $user->avatar_url }}" width="150px" class="img-thumbnail"/>
                          </a>
                        <p>
                      @endif
                      @if($user->bio != null || $user->bio != "")
                        <p align="center"><i>{{ $user->bio }}</i></p>
                      @endif
                      <table class="table">
                        <tr>
                          <th>Name</th>
                          <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                          <th>Username</th>
                          <td>{{ "@".$user->username }}</td>
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
                          <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                        </tr>
                        <tr>
                          <th>Rank</th>
                          <td>
                            <img src='{{ $user->rank["badge"] }}' width="30px"/>
                            {{ $user->rank["rank"] }} ({{ $user->totalitineraries }} itineraries)
                          </td>
                        </tr>
                        <tr>
                        <tr>
                          <th>Date Registered</th>
                          <td>{{ date_format(date_create($user->created_at),"d/m/Y g:i a") }}</td>
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

                </div>
              </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
  <script>
    // Auto launch BackPack Track Android App, Android deeplinking
    function launchApp() {
      var usrId = <?php echo $user->id; ?>;
      window.location.replace('backpacktrack://user?user_id='+usrId);
    }

    $(document).ready(function() {
        $.noConflict();
        // DataTables
        $('#tableItineraries, #tableComments').DataTable();
        launchApp();
    });
  </script>
@endpush
