@extends('layouts.adminpanel')

@section('title', 'Itineraries')

@section('breadcrumb')
  <li class="list-inline-item">
      <a href="{{ route('dashboard') }}">Dashboard</a>
  </li>
  <li class="list-inline-item seprate">
      <span>/</span>
  </li>
  <li class="list-inline-item active">Itineraries</li>
@endsection

@section('pageheader', 'Itineraries')

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
      <table class="table table-borderless table-data3" id="tableItineraries">
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
                    <td>{{ $itinerary->duration }}</td>
                    <td>{{ $itinerary->totallikes }}</td>
                    <td>{{ $itinerary->totalcomments }}</td>
                    <td>{{ $itinerary->country->currency }} {{ $itinerary->totalbudget }}</td>
                    <td>
                        <div class="table-data-feature">
                          <a href="/viewItinerary/{{ $itinerary->id }}" target="_blank" class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Activities">
                              <i class="zmdi zmdi-view-list-alt"></i>
                          </a>
                          <a href="/itineraries/{{ $itinerary->id }}/edit" class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit Itinerary">
                              <i class="zmdi zmdi-edit"></i>
                          </a>
                          <form id="delete-form" action="/itineraries/delete" method="POST" onsubmit="return confirm('Do you really want to delete this itinerary?');">
                              @csrf
                              <input type="hidden" name="itinerary_id" value="{{ $itinerary->id }}">
                              <button type="submit" class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete Itinerary">
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
        var table = $('#tableItineraries').DataTable( {
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
