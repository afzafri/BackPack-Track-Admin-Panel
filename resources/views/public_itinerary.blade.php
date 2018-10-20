<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="BackPack Track Itinerary">
    <meta name="author" content="Afif Zafri">
    <meta name="keywords" content="BackPack Track Itinerary">

    <!-- Title Page-->
    <title>{{ $data->title }}</title>

    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('images/icon/logo-mini.png') }}">

    <!-- Fontfaces CSS-->
    <link href="{{ asset('css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{ asset('vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">

    <!-- Vendor CSS -->
    <link href="{{ asset('vendor/lightbox2/dist/css/lightbox.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/bootstrap-fileinput/themes/explorer-fa/theme.min.css') }}" rel="stylesheet" media="all">
  </head>
  <body>
    {{ json_encode($data) }}

    <!-- Jquery JS-->
    <script src="{{ asset('vendor/jquery-3.2.1.min.js') }}"></script>
    <!-- Bootstrap JS-->
    <script src="{{ asset('vendor/bootstrap-4.1/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
    <!-- Vendor JS -->
    <script src="{{ asset('vendor/chartjs/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-fileinput/themes/explorer-fa/theme.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-fileinput/themes/fa/theme.min.js') }}"></script>
  </body>
</html>
