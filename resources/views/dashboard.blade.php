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
              labels: {!!  $countrylabels !!},
              datasets: [
                {
                  label: "Total Itineraries",
                  data: {!!  $totalitinerary !!},
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
