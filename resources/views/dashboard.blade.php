@extends('layouts.adminpanel')

@section('title', 'Dashboard')

@section('breadcrumb')
  <li class="list-inline-item active">Dashboard</li>
@endsection

@section('pageheader', 'Dashboard')

@section('content')

  <br>
  <!-- Statistics -->
  <div class="card">
    <div class="card-header">
        <strong class="card-title mb-3">Statistics</strong>
    </div>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="daily-tab" data-toggle="tab" href="#daily" role="tab" aria-controls="daily" aria-selected="true">Daily</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="monthly-tab" data-toggle="tab" href="#monthly" role="tab" aria-controls="monthly" aria-selected="false">Monthly</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="Yearly-tab" data-toggle="tab" href="#Yearly" role="tab" aria-controls="Yearly" aria-selected="false">Yearly</a>
      </li>
    </ul>
    <div class="tab-content pl-3 p-1" id="myTabContent">
      <div class="tab-pane fade show active" id="daily" role="tabpanel" aria-labelledby="daily-tab">

        New registered Users <span class="badge badge-primary">{{ $statistics['daily']['users'] }}</span><br>
        New posted Itineraries <span class="badge badge-warning">{{ $statistics['daily']['itineraries'] }}</span><br>
        New posted Comments <span class="badge badge-success">{{ $statistics['daily']['comments'] }}</span>

      </div>
      <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">

        New registered Users <span class="badge badge-primary">{{ $statistics['monthly']['users'] }}</span><br>
        New posted Itineraries <span class="badge badge-warning">{{ $statistics['monthly']['itineraries'] }}</span><br>
        New posted Comments <span class="badge badge-success">{{ $statistics['monthly']['comments'] }}</span>

      </div>
      <div class="tab-pane fade" id="Yearly" role="tabpanel" aria-labelledby="Yearly-tab">

        New registered Users <span class="badge badge-primary">{{ $statistics['yearly']['users'] }}</span><br>
        New posted Itineraries <span class="badge badge-warning">{{ $statistics['yearly']['itineraries'] }}</span><br>
        New posted Comments <span class="badge badge-success">{{ $statistics['yearly']['comments'] }}</span>

      </div>
    </div>
  </div>

<div class="row">

  <!-- Top 5 most commented itineraries -->
  <div class="col-lg-6">
    <div class="au-card m-b-30">
        <div class="au-card-inner">
            <h3 class="title-2 m-b-40">Top 5 Most Commented Itineraries</h3>

            <ul class="list-group list-group-flush">

                @foreach ($popularItineraries as $itinerary)

                  <li class="list-group-item">
                      <a href="/itineraries/{{ $itinerary->itinerary_id }}/view">
                          {{ $itinerary->itinerary_title }} by {{ $itinerary->itinerary_poster }}
                      </a>
                      -
                      <span class="badge badge-info">{{ $itinerary->total }}</span> Comments
                  </li>

                @endforeach

            </ul>

        </div>
    </div>
  </div>

  <!-- Top 5 popular countries bar chart -->
  <div class="col-lg-6">
    <div class="au-card m-b-30">
        <div class="au-card-inner">
            <h3 class="title-2 m-b-40">Top 5 Popular Countries</h3>
            <canvas id="countriesBarChart"></canvas>
        </div>
    </div>
  </div>

</div>

@endsection

@push('scripts')
  <script>

      try {

        // single bar chart
        var ctx = document.getElementById("countriesBarChart");
        if (ctx) {
          ctx.height = 150;
          var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: {!! json_encode($popularCountries['labels']) !!},
              datasets: [
                {
                  label: "Total Itineraries",
                  data: {!! json_encode($popularCountries['data']) !!},
                  borderColor: "rgba(0, 123, 255, 0.9)",
                  borderWidth: "0",
                  backgroundColor: "rgba(0, 123, 255, 0.5)"
                }
              ]
            },
            options: {
              legend: {
                position: 'top',
                labels: {
                  fontFamily: 'Poppins'
                }

              },
              scales: {
                xAxes: [{
                  ticks: {
                    fontFamily: "Poppins"

                  }
                }],
                yAxes: [{
                  ticks: {
                    beginAtZero: true,
                    fontFamily: "Poppins"
                  }
                }]
              }
            }
          });
        }

      } catch (error) {
        console.log(error);
      }

  </script>
@endpush
