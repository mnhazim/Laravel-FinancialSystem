@extends('private_master.app')

@section('top-header')
<!-- Header -->

@include('sweetalert::alert')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">
        <div class="row">
          <div class="col-lg-12 col-md-10 mb-5">
          <h1><span class="text-white bg-default">&nbsp;Main Account&nbsp;</span></h1>
          </div>
        </div>
          <!-- Card stats -->
          <div class="row">
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Current Money</h5>
                      <span class="h2 font-weight-bold mb-0">RM {{ number_format( $user->userDetails->money , 2) }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                        <i class="ni ni-money-coins"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                  @if($lastUpdateTransaction != null)
                    {!! ($lastUpdateTransaction->lookup->getMaster() == 2 
                    ? '<span class="text-success mr-2"><i class="fa fa-arrow-up"></i>&nbsp;In</span>'
                    : '<span class="text-danger mr-2"><i class="fa fa-arrow-down"></i>&nbsp;Out</span>'
                    ) !!}
                  @endif
                    <span class="text-nowrap">update {{ ($lastUpdateTransaction != null ) ? \Carbon\Carbon::parse($lastUpdateTransaction->created_at)->format('d-m-Y') : '---' }}</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Commitment</h5>
                      <span class="h2 font-weight-bold mb-0">RM {{ number_format($getSumMonthly,2) }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                        <i class="fas fa-credit-card"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-nowrap">/ Monthly</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">{{ \Carbon\Carbon::today()->format('M') }}-Income </h5>
                      <span class="h2 font-weight-bold mb-0">RM {{ number_format( $thisMonthIncome , 2) }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                        <i class="fa fa-arrow-up"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    {!! ($percentageIncome > 50 )
                    ? '<span class="text-success mr-2">&nbsp;'. $percentageIncome .'%</span>'
                    : '<span class="text-danger mr-2">&nbsp;'. $percentageIncome .'%</span>'
                    !!}
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">{{ \Carbon\Carbon::today()->format('M') }}-Expenses </h5>
                      <span class="h2 font-weight-bold mb-0">RM {{ number_format( $thisMonthExpenses , 2) }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                        <i class="fa fa-arrow-down"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    {!! ($percentageExpenses < 50 )
                    ? '<span class="text-success mr-2">&nbsp;'. $percentageExpenses .'%</span>'
                    : '<span class="text-danger mr-2">&nbsp;'. $percentageExpenses .'%</span>'
                    !!}
                  </p>
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
                <h2 class="text-white mb-0">Transaction In This Month: {{ \Carbon\Carbon::today()->format('F Y') }}</h2>
            </div>
            <div class="col text-right">
                <a href="" class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModal">INCOME</a>
                <a href="" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#exampleModal1">EXPENSES</a>
                <a href="" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#exampleModal2">COMMITMENT</a>
            </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Chart -->
            <div class="chart">
            <!-- Chart wrapper -->
            <canvas id="myChart" class="chart-canvas"></canvas>
            </div>
        </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-xl-7 mb-7 mb-xl-0">
        <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0"><a href="/transaction">Latest Transaction</a></h3>
            </div>
            </div>
        </div>
        <div class="table-responsive">
            <!-- Projects table -->
            <table class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                <th scope="col">#</th>
                <th scope="col">Reason</th>
                <th scope="col">Kategori</th>
                <th scope="col">RM</th>
                <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
            @php
            $d = 1;
            @endphp
            @foreach($latestTransaction as $transaction)
            <tr>
                <th>{{ $d++ }}</th>
                <th scope="row">{{ $transaction->log_reason }}</th>
                <th scope="row">{{$transaction->lookup->title}}</th>
                <td><i class="fas {{ ($transaction->lookup->getMaster() == 2) || $transaction->lookup->id == 17 ? 'fa-arrow-up text-success' : 'fa-arrow-down text-warning' }} mr-3"></i>RM {{ number_format($transaction->log_rm,2) }}</td>
                <td>{{$transaction->created_at->diffForHumans()}}</td>
            </tr>
            @endforeach
                
            </tbody>
            </table>
        </div>
        </div>
    </div>
    <div class="col-xl-5">
        <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Monthly Commitment</h3>
            </div>
            <div class="col text-right">
                <a href="/commitment" class="btn btn-sm btn-primary">See all</a>
            </div>
            </div>
        </div>
        <div class="table-responsive">
            <!-- Projects table -->
            <table class="table align-items-center table-flush">
            <thead class="thead-light">
                <tr>
                <th scope="col">Commitment</th>
                <th scope="col">Monthly</th>
                <th scope="col">Progress / Total Pay</th>
                </tr>
            </thead>
            <tbody>
            @if(count($getCommitment) > 0)
                    @foreach($getCommitment as $commitment)
                    <tr>
                      <th scope="row">{{ $commitment->title }}</th>
                      <td>RM {{ number_format($commitment->monthly,2) }}</td>
                      <td>
                      @if($commitment->unlimit == 0)
                        <div class="d-flex align-items-center">
                          <span class="mr-2">{{ $commitment->getBalanceStatus()}}%</span>
                          <div>
                            <div class="progress">
                              <div class="progress-bar 
                              @if($commitment->getBalanceStatus() <= 20)
                                bg-gradient-danger 
                              @elseif($commitment->getBalanceStatus() >= 21 && $commitment->getBalanceStatus() <= 40)
                                bg-gradient-warning 
                              @elseif($commitment->getBalanceStatus() >= 41 && $commitment->getBalanceStatus() <= 60)
                                bg-gradient-info
                              @elseif($commitment->getBalanceStatus() >= 61 && $commitment->getBalanceStatus() <= 80)
                                bg-gradient-primary 
                              @else
                                bg-gradient-success 
                              @endif
                              role="progressbar" aria-valuenow="{{ $commitment->getBalanceStatus()}}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $commitment->getBalanceStatus()}}%;"></div>
                            </div>
                          </div>
                        </div>
                        @else
                        RM {{ number_format($commitment->total,2) }}
                        @endif
                      </td>
                    </tr>
                    @endforeach
                @else
                <tr>
                    <th scope="row" colspan="5">No Commitment Found</th>
                </tr>
                @endif
            </tbody>
            </table>
        </div>
        </div>
    </div>
    </div>


    <!-- transaction in modal start -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form method="post" action="/transactionIn">
            @csrf
            <div class="modal-body" id="transactionIn">
                <h6 class="heading-small text-muted mb-4" >Transaction IN</h6>
                <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group" >
                        <label class="form-control-label">Kategori</label>
                        <select class="form-control form-control-alternative" required name="kategori_id">
                        <option value="">Select</option>
                        @foreach($incomeList as $income)
                          <option value="{{ $income->id }}">{{ $income->title }}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                    
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-city">Total In (RM)</label>
                        <input type="number" step="0.01" name="total" id="input-city" class="form-control form-control-alternative" placeholder="Total " autocomplete="off" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label" >Reason</label>
                        <input type="text" name="reason" class="form-control form-control-alternative" placeholder="Reason" autocomplete="off" required id="autoReason">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="form-control-label" for="input-address">Date : {{ \Carbon\Carbon::today()->format('d-m-Y') }}</label>
                      </div>
                    </div>
                  </div>
                <hr class="my-1" />
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
            </form>
          </div>
        </div>
      </div>
      <!-- transaction in modal end -->

      <!-- transaction out modal start -->
      <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form method="post" action="/transactionOut">
            @csrf
            <div class="modal-body" id="transactionOut">
                <h6 class="heading-small text-muted mb-4">Transaction OUT</h6>

                <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label">Kategori</label>
                        <select class="form-control form-control-alternative" required name="kategori_id">
                        <option value="">Select</option>
                        @foreach($expensesList as $expenses)
                          <option value="{{ $expenses->id }}">{{ $expenses->title }}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-city">Total In (RM)</label>
                        <input type="number" step="0.01" name="total" class="form-control form-control-alternative" placeholder="Total " autocomplete="off" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label">Reason</label>
                        <input type="text" name="reason" class="form-control form-control-alternative" placeholder="Reason" autocomplete="off" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="form-control-label">Date : {{ \Carbon\Carbon::today()->format('d-m-Y') }}</label>
                      </div>
                    </div>
                  </div>
                <hr class="my-1" />
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger">Submit</button>
            </div>
            </form>
          </div>
        </div>
      </div>
      <!-- transaction out modal end -->

      <!-- commitment out modal start -->
      <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form method="post" action="/transactionOutByCommitment">
            @csrf
            <div class="modal-body ">
                <h6 class="heading-small text-muted mb-4">Commitment OUT</h6>

                <div class="row ">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label" >Commitment List</label>
                        <select class="form-control form-control-alternative" required name="id" id="commitmentId">
                        <option value="">Select</option>
                        @foreach($getCommitment as $commitment)
                        <option value="{{ $commitment->id }}">{{ $commitment->title }}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label" for="input-city">Total In (RM)</label>
                        <input id="commitmentInput" type="number" step="0.01" name="total" class="form-control form-control-alternative" placeholder="Total " autocomplete="off" required>
                        <small class="text-info" id="infoBalance"></small>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="form-control-label" for="input-address">Date : {{ \Carbon\Carbon::today()->format('d-m-Y') }}</label>
                        
                        <p><small class="text-info"><strong>Info:</strong> You need to add your commitment first.</small></p>
                      </div>
                    </div>
                  </div>
                <hr class="my-1" />
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-warning">Submit</button>
            </div>
            </form>
          </div>
        </div>
      </div>
      <!-- commitment out modal end -->
@stop

@section('script')
<script>
  var e,ctx = document.getElementById('myChart').getContext('2d');
  $.ajax({
        url: "/tojson/overviewDashboard",
        type: "GET",
        success : function (data) {
          var myChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: data.day,
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
  $( document ).ready(function() {
    $('#transactionIn select').change(function(){
      var reason = $(this).find('option:selected').text();
      $("#transactionIn input[type='text']").val(reason);
    });

    $('#transactionOut select').change(function(){
      var reason = $(this).find('option:selected').text();
      $("#transactionOut input[type='text']").val(reason);
    });

    $('#commitmentId').change(function() {
      var id = $(this).val();
      if(id != ''){
        $.ajax({  
            url:"/tojson/commitmentList",  
            method:"POST",  
            data:{
              "_token": "{{ csrf_token() }}",
              id:id
            },  
            dataType:"json",  
            success:function(data){
              if(data.unlimit == 0){
                var gotBalance = data.balance - data.monthly;
                $('#infoBalance').text("Your Balance: RM " + data.balance);
                $('#commitmentInput').val((gotBalance < 0) ? data.balance : data.monthly);
              } else{
                $('#infoBalance').text('');
                $('#commitmentInput').val(data.monthly);
              }
              
            }
        });
      } else {
        $('#commitmentInput').val('');
      }
    });
  });
</script>
@stop
