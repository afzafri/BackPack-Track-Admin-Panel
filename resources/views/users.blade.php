@extends('layouts.adminpanel')

@section('title', 'List of Users')

@section('pageheader', 'List of Users')

@section('content')
  {{ $users }}
@endsection
