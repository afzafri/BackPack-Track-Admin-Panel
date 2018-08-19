@extends('layouts.adminpanel')

@section('title', 'Dashboard')

@section('pageheader', 'Itineraries')

@section('content')
    <br>
    <div class="table-responsive table--no-card m-b-30">
      <table class="table table-borderless table-data3">
          <thead>
              <tr>
                  <th>ID.</th>
                  <th>User</th>
                  <th>Country</th>
                  <th>Trip Title</th>
                  <th>Duration</th>
                  <th>Total Budget</th>
                  <th>Action</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($itineraries as $itinerary)
                <tr>
                    <td>{{ $itinerary->id }}</td>
                    <td>{{ $itinerary->user->name }}</td>
                    <td>{{ $itinerary->country->name }}</td>
                    <td>{{ $itinerary->title }}</td>
                    <td>{{ $durations[$itinerary->id] }}</td>
                    <td>{{ $totalbudgets[$itinerary->id] }}</td>
                    <td></td>
                </tr>
              @endforeach
          </tbody>
      </table>
    </div>
@endsection
