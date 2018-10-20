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

    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <span class="navbar-brand mb-0 h1"><img src="{{ asset('images/icon/logo-mini.png') }}" width="40px"/> BackPack Track</span>
        <a class="nav-item nav-link active" id="nav-activities-tab" data-toggle="tab" href="#nav-activities" role="tab" aria-controls="nav-activities" aria-selected="true">Activities</a>
        <a class="nav-item nav-link" id="nav-map-tab" data-toggle="tab" href="#nav-map" role="tab" aria-controls="nav-map" aria-selected="false">Map</a>
        <a class="nav-item nav-link" id="nav-budget-tab" data-toggle="tab" href="#nav-budget" role="tab" aria-controls="nav-budget" aria-selected="false">Budget</a>
        <a class="nav-item nav-link" id="nav-comments-tab" data-toggle="tab" href="#nav-comments" role="tab" aria-controls="nav-comments" aria-selected="false">Comments</a>
      </div>
    </nav>

    <br>

    <div class="container">

         <div class="tab-content" id="nav-tabContent">
           <div class="tab-pane fade show active" id="nav-activities" role="tabpanel" aria-labelledby="nav-activities-tab">

               <div class="card">
                  <h4 class="card-header">
                    {{ $data->title }}
                  </h4>
                  <div class="card-body">
                    <h5><i class="fas fa-user"></i> {{ $data->user->name }} </h5>
                    <h5><i class="fas fa-map-marker-alt"></i> {{ $data->country->name }} </h5>
                    <h5><i class="far fa-calendar"></i> {{ date_format(date_create($data->created_at),"d/m/Y") }} </h5>
                  </div>
                </div>
                <br>

                @foreach ($data->activities as $date => $activity)

                  {{ date_format(date_create($date),"d/m/Y") }}

                  <br><br>
                @endforeach

           </div>
           <div class="tab-pane fade" id="nav-map" role="tabpanel" aria-labelledby="nav-map-tab">...</div>
           <div class="tab-pane fade" id="nav-budget" role="tabpanel" aria-labelledby="nav-budget-tab">...</div>
           <div class="tab-pane fade" id="nav-comments" role="tabpanel" aria-labelledby="nav-comments-tab">...</div>
         </div>

     </div>

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
