@extends('layouts.adminpanel')

@section('title', 'Create new article')

@section('pageheader', 'Create new article')

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
      <form action="/articles/create" method="post" onsubmit="return confirm('Do you really want to create this article?');">
          @csrf
          <div class="card-body card-block">
                <div class="form-group">
                    <label class="form-control-label">Title</label>
                    <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" required autofocus>

                    @if ($errors->has('title'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="form-control-label">Author</label>
                    <input id="author" type="text" class="form-control{{ $errors->has('author') ? ' is-invalid' : '' }}" name="author" value="{{ old('author') }}" required>

                    @if ($errors->has('author'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('author') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="form-control-label">Date</label>
                    <input id="date" type="date" class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" value="{{ old('date') }}" required>

                    @if ($errors->has('date'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('date') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="form-control-label">Summary</label>
                    <textarea id="summary" class="form-control{{ $errors->has('summary') ? ' is-invalid' : '' }}" name="summary" required>{{ old('summary') }}</textarea>

                    @if ($errors->has('summary'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('summary') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="form-control-label">Content</label>
                    <textarea rows="20" id="content" class="form-control {{ $errors->has('content') ? ' is-invalid' : '' }}" name="content" required>{{ old('content') }}</textarea>

                    @if ($errors->has('content'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('content') }}</strong>
                        </span>
                    @endif
                </div>
          </div>
          <div class="card-footer">
              <button type="submit" class="btn btn-primary btn-sm">
                  <i class="fa fa-save"></i> Save
              </button>
          </div>
      </form>
  </div>

@endsection

@push('scripts')
  <script>

    $(document).ready(function() {

        // CKEditor
        CKEDITOR.replace('content', {
          height: 400,
        });
    });
  </script>
@endpush
