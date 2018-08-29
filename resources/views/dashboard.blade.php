@extends('layouts.adminpanel')

@section('title', 'Dashboard')

@section('breadcrumb')
  <li class="list-inline-item active">Dashboard</li>
@endsection

@section('pageheader', 'Dashboard')

@section('content')

  <br>
  <div class="card">
    <div class="card-header">
        <strong class="card-title mb-3">Statistics</strong>
    </div>
    <div class="card-body">

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

          New registered Users <span class="badge badge-primary">{{ $daily['users'] }}</span><br>
          New posted Itineraries <span class="badge badge-warning">{{ $daily['itineraries'] }}</span><br>
          New posted Comments <span class="badge badge-success">{{ $daily['comments'] }}</span>

        </div>
        <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">

          New registered Users <span class="badge badge-primary"></span><br>
          New posted Itineraries <span class="badge badge-warning"></span><br>
          New posted Comments <span class="badge badge-success"></span>

        </div>
        <div class="tab-pane fade" id="Yearly" role="tabpanel" aria-labelledby="Yearly-tab">

          New registered Users <span class="badge badge-primary"></span><br>
          New posted Itineraries <span class="badge badge-warning"></span><br>
          New posted Comments <span class="badge badge-success"></span>

        </div>
      </div>


    </div>
  </div>

  <div class="card">
      <div class="card-header">
          <strong class="card-title mb-3">Top 5 Popular Countries</strong>
      </div>
      <div class="card-body">
        <canvas id="countriesBarChart"></canvas>
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
