@extends('layouts.adminpanel')

@section('title', 'Activities')

@section('pageheader', $data['itinerary']['title'] . ' - By ' . $data['itinerary']['user']['name'])

@section('content')

  {{ $data['activities'] }}

@endsection
