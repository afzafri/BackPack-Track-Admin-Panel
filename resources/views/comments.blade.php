@extends('layouts.adminpanel')

@section('title', 'Manage User Comments')

@section('breadcrumb')
  <li class="list-inline-item">
      <a href="{{ route('dashboard') }}">Dashboard</a>
  </li>
  <li class="list-inline-item seprate">
      <span>/</span>
  </li>
  <li class="list-inline-item active">Manage Users Comments</li>
@endsection

@section('pageheader', 'Manage User Comments')

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
    <table class="table table-borderless table-data3" id="tableComments">
        <thead>
            <tr>
                <th>ID.</th>
                <th>Commenter</th>
                <th>Email</th>
                <th>Comment</th>
                <th>Itinerary Title</th>
                <th>Itinerary Owner</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($comments as $comment)
              <tr>
                  <td>{{ $comment->id }}</td>
                  <td>{{ $comment->user->name }}</td>
                  <td>{{ $comment->user->email }}</td>
                  <td>{{ $comment->message }}</td>
                  <td>{{ $comment->itinerary->title }}</td>
                  <td>{{ $comment->itinerary->user->name }}</td>
                  <td>
                      <div class="table-data-feature">
                        <form id="delete-form" action="/comments/delete" method="POST" onsubmit="return confirm('Do you really want to delete this user comment?');">
                            @csrf
                            <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                            <button type="submit" class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete User Comment">
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
        var table = $('#tableComments').DataTable( {
            dom: 'Bfrtilp',
            buttons: [
                'copy', 'excel', 'pdf',
            ]
        });

    });
  </script>
@endpush
