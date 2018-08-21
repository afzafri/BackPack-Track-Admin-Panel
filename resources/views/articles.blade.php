@extends('layouts.adminpanel')

@section('title', 'Articles')

@section('pageheader', 'Articles')

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
    <a href="/articles/create" class="btn btn-success float-right"/><i class="fa fa-plus"></i> Create new article</a> <br>
    <table class="table table-borderless table-data3" id="tableArticles">
        <thead>
            <tr>
                <th>ID.</th>
                <th>Title</th>
                <th>Author</th>
                <th>Date</th>
                <th>Summary</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($articles as $article)
              <tr>
                  <td>{{ $article->id }}</td>
                  <td>{{ $article->title }}</td>
                  <td>{{ $article->author }}</td>
                  <td>{{ date('d-m-Y', strtotime($article->date)) }}</td>
                  <td>{{ $article->summary }}</td>
                  <td>
                      <div class="table-data-feature">
                        <a href="/articles/{{ $article->id }}/view" class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Article">
                            <i class="zmdi zmdi-view-list-alt"></i>
                        </a>
                        <a href="/articles/{{ $article->id }}/edit" class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit Article">
                            <i class="zmdi zmdi-edit"></i>
                        </a>
                        <form id="delete-form" action="/articles/delete" method="POST" onsubmit="return confirm('Do you really want to delete this article?');">
                            @csrf
                            <input type="hidden" name="article_id" value="{{ $article->id }}">
                            <button type="submit" class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete Article">
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
        var table = $('#tableArticles').DataTable( {
            dom: 'Bfrtilp',
            buttons: [
                'copy', 'excel', 'pdf',
            ]
        });

    });
  </script>
@endpush
