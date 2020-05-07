@extends('private_master.app')

@section('top-header')
<!-- Header -->

@include('sweetalert::alert')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">

          <!-- Card stats -->
          <div class="row">
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">INCOME - {{ \Carbon\Carbon::today()->format('Y') }}</h5>
                      <span class="h2 font-weight-bold mb-0">RM {{ number_format( $thisYearIncome, 2) }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                        <i class="ni ni-money-coins"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">EXPENSES - {{ \Carbon\Carbon::today()->format('Y') }}</h5>
                      <span class="h2 font-weight-bold mb-0">RM {{ number_format( $thisYearExpenses, 2) }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                        <i class="fas fa-credit-card"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">INCOME - ALL </h5>
                      <span class="h2 font-weight-bold mb-0">RM {{ number_format( $allIncome, 2) }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                        <i class="fa fa-arrow-up"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">EXPENSES - ALL </h5>
                      <span class="h2 font-weight-bold mb-0">RM {{ number_format( $allExpenses, 2) }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                        <i class="fa fa-arrow-down"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-xl-12 mb-5 mb-xl-0">
        <div class="card bg-gradient-default shadow">
        <div class="card-header bg-transparent">
            <div class="row align-items-center">
            <div class="col">
                <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6>
                <h2 class="text-white mb-0">Transaction In This Year: {{ \Carbon\Carbon::today()->format('Y') }}</h2>
            </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Chart -->
            <div class="chart">
            <!-- Chart wrapper -->
            <canvas id="chartYear" class="chart-canvas"></canvas>
            </div>
        </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-6 mt-3">
        <div class="card shadow">
        <div class="card-header bg-transparent">
            <div class="row align-items-center">
            <div class="col">
                <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6>
                <h2 class=" mb-0">Total By Income List: {{ \Carbon\Carbon::today()->format('Y') }}</h2>
            </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Chart -->
            <div class="chart">
            <!-- Chart wrapper -->
            <canvas id="chartIncomeDetail" class="chart-canvas"></canvas>
            </div>
        </div>
        </div>
    </div>
    <div class="col-xl-6 mt-3">
        <div class="card shadow">
        <div class="card-header bg-transparent">
            <div class="row align-items-center">
            <div class="col">
                <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6>
                <h2 class=" mb-0">Total By Expenses List: {{ \Carbon\Carbon::today()->format('Y') }}</h2>
            </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Chart -->
            <div class="chart">
            <!-- Chart wrapper -->
            <canvas id="chartExpensesDetail" class="chart-canvas"></canvas>
            </div>
        </div>
        </div>
    </div>
</div>
@stop

@section('script')
<script>
  var e,graph3 = document.getElementById('chartExpensesDetail').getContext('2d');
  $.ajax({
        url: "/tojson/chartExpensesDetail",
        type: "GET",
        success : function (data) {
          var chartExpensesDetail = new Chart(graph3, {
          type: 'bar',
          data: {
            labels: data.label,
            datasets: [{
                label: 'Income',
                data: data.value,
                backgroundColor:'rgba(245, 54, 92)'
            }]
          },
          options: {
              scales: {
                  yAxes: [{
                      ticks: {
                          callback: function(e) {
                              if (!(e % 10))
                                  return "RM" + e
                          }
                      }
                  }]
              }
          },
      });
        },
        error : function (data) {
            console.log(data);
        }
    });
</script>
<script>
  var e,graph2 = document.getElementById('chartIncomeDetail').getContext('2d');
  $.ajax({
        url: "/tojson/chartIncomeDetail",
        type: "GET",
        success : function (data) {
          var chartIncomeDetail = new Chart(graph2, {
          type: 'bar',
          data: {
            labels: data.label,
            datasets: [{
                label: 'Income',
                data: data.value,
                backgroundColor:'rgba(45, 206, 137)'
            }]
          },
          options: {
              scales: {
                  yAxes: [{
                      ticks: {
                          callback: function(e) {
                              if (!(e % 10))
                                  return "RM" + e
                          }
                      }
                  }]
              }
          },
      });
        },
        error : function (data) {
            console.log(data);
        }
    });
</script>
<script>
  var e,ctx = document.getElementById('chartYear').getContext('2d');
  $.ajax({
        url: "/tojson/graphTransactionYear",
        type: "GET",
        success : function (data) {
          var myChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: data.month,
            datasets: [{
                label: 'Income',
                data: data.income,
                borderColor: [
                  'rgba(45, 206, 137)'
                ],
                borderWidth: 3
            },{
                label: 'Expenses',
                data: data.expenses,
                borderColor: [
                    'rgba(245, 54, 92)'
                ],
                borderWidth: 3
            }]
          },
          options: {
              scales: {
                  yAxes: [{
                      ticks: {
                          callback: function(e) {
                              if (!(e % 10))
                                  return "RM" + e
                          }
                      }
                  }]
              },
              elements: {
                line: {
                  tension : 0.15
                }
              }
          },
      });
        },
        error : function (data) {
            console.log(data);
        }
    });

</script>

@stop
