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
                    <td>
                        <div class="table-data-feature">
                          <button id="viewButton" class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="View" value="{{ $itinerary->id }}">
                              <i class="zmdi zmdi-view-list-alt"></i>
                          </button>
                          <a href="/itineraries/{{ $itinerary->id }}/edit" class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                              <i class="zmdi zmdi-edit"></i>
                          </a>
                          <form id="delete-form" action="/itineraries/delete" method="POST" onsubmit="return confirm('Do you really want to delete this itinerary?');">
                              @csrf
                              <input type="hidden" name="itinerary_id" value="{{ $itinerary->id }}">
                              <button type="submit" class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
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

    $(document).on('click', '#viewButton', function() {
        var id = $(this).val();

        alert(id);
    });

  </script>
@endpush
