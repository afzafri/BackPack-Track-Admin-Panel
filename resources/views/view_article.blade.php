@extends('layouts.adminpanel')

@section('title', 'Article')

@section('breadcrumb')
  <li class="list-inline-item">
      <a href="{{ route('dashboard') }}">Dashboard</a>
  </li>
  <li class="list-inline-item seprate">
      <span>/</span>
  </li>
  <li class="list-inline-item">
      <a href="{{ route('articles') }}">Articles</a>
  </li>
  <li class="list-inline-item seprate">
      <span>/</span>
  </li>
  <li class="list-inline-item active">Article ID:{{ $article->id }}</li>
@endsection

@section('pageheader', $article->title)

@section('content')

  <h3 class="title-5 m-b-35">
    Author: {{ $article->author }} <br>
    Date: {{ date('d-m-Y', strtotime($article->date)) }}
  </h3>

  <div class="card">
      <div class="card-body">

          <div class="alert alert-secondary" role="alert">
            <i>{{ $article->summary }}</i>
          </div>

          {!! $article->content !!}

      </div>
  </div>

@endsection
