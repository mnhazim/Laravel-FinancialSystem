@extends('private_master.app')

@section('top-header')
@include('sweetalert::alert')
<!-- Header -->
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          @if (Session::has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <span class="alert-inner--text"><strong>Success!</strong> Now you can easily select commitment!</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            @endif
            @if ($errors->any() || Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <span class="alert-inner--text"><strong>Error!</strong> Something Wrong, try again!</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            @endif
        </div>
      </div>
    </div>
@stop

@section('content')
<div class="row">
        <div class="col col-xl-12 mb-5 mb-xl-0">
          <div class="card shadow border-0">
            <div class="card-header bg-danger border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0 text-white">List Commitment</h3>
                </div>
                <div class="col text-right">
                  <a href="" data-toggle="modal" data-target="#addCommitment" class="btn btn-sm btn-primary">+ Add New</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Commitment</th>
                    <th scope="col">Total</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Monthly</th>
                    <th scope="col">Progress / Total Pay</th>
                    <th scope="col">Date Created</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                @if(count($getCommitment) > 0)
                    @foreach($getCommitment as $commitment)
                    <tr>
                      <th scope="row">{{ $commitment->title }}</th>
                      <td>RM {{ number_format($commitment->total,2) }}</td>
                      <td>{!! ($commitment->unlimit == 0) ? 'RM ' . number_format($commitment->balance,2) : '<span class="badge badge-pill badge-danger text-uppercase">Unlimit</span>' !!}</td>
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
                        <span class="badge badge-pill badge-danger text-uppercase">Unlimit</span>
                        @endif
                      </td>
                      <td>{{ $commitment->created_at->diffForHumans() }}</td>
                      <td>
                        <button  class="btn btn-icon-only btn-success rounded-circle forceCompleteCommitment" id="{{ $commitment->id }}" title="Complete">
                            <span class="btn-inner--icon"><i class="ni ni-check-bold"></i></span>
                        </button>
                        <button  class="btn btn-icon-only btn-warning rounded-circle updateCommitment" title="Update" id="{{ $commitment->id }}">
                            <span class="btn-inner--icon"><i class="ni ni-settings"></i></span>
                        </button>
                        <button  class="btn btn-icon-only btn-danger rounded-circle removeCommitment" id="{{ $commitment->id }}" title="Delete">
                            <span class="btn-inner--icon"><i class="ni ni-fat-remove"></i></span>
                        </button>
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
            <div class="card-footer py-4">
              <nav aria-label="...">
                <ul class="pagination justify-content-end mb-0">
                  {{$getCommitment->links()}}
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col col-xl-12 mb-5 mb-xl-0">
          <div class="card shadow">
            <div class="card-header bg-success border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">List Commitment Completed</h3>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Commitment</th>
                    <th scope="col">Total</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Monthly</th>
                    <th scope="col">Progress / Total Pay</th>
                    <th scope="col">Date Created</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                @if(count($getCommitmentComplete) > 0)
                    @foreach($getCommitmentComplete as $commitmentComplete)
                    <tr>
                      <th scope="row">{{ $commitmentComplete->title }}</th>
                      <td>RM {{ number_format($commitmentComplete->total,2) }}</td>
                      <td>{!! ($commitmentComplete->unlimit == 0) ? 'RM ' . number_format($commitmentComplete->balance,2) : '<span class="badge badge-pill badge-danger text-uppercase">Unlimit</span>' !!}</td>
                      <td>RM {{ number_format($commitmentComplete->monthly,2) }}</td>
                      <td>
                      @if($commitmentComplete->unlimit == 0)
                        <div class="d-flex align-items-center">
                          <span class="mr-2">{{ $commitmentComplete->getBalanceStatus()}}%</span>
                          <div>
                            <div class="progress">
                              <div class="progress-bar 
                              @if($commitmentComplete->getBalanceStatus() <= 20)
                                bg-gradient-danger 
                              @elseif($commitmentComplete->getBalanceStatus() >= 21 && $commitmentComplete->getBalanceStatus() <= 40)
                                bg-gradient-warning 
                              @elseif($commitmentComplete->getBalanceStatus() >= 41 && $commitmentComplete->getBalanceStatus() <= 60)
                                bg-gradient-info
                              @elseif($commitmentComplete->getBalanceStatus() >= 61 && $commitmentComplete->getBalanceStatus() <= 80)
                                bg-gradient-primary 
                              @else
                                bg-gradient-success 
                              @endif
                              role="progressbar" aria-valuenow="{{ $commitmentComplete->getBalanceStatus()}}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $commitmentComplete->getBalanceStatus()}}%;"></div>
                            </div>
                          </div>
                        </div>
                        @else
                        <span class="badge badge-pill badge-danger text-uppercase">Unlimit</span>
                        @endif
                      </td>
                      <td>{{ $commitmentComplete->created_at->diffForHumans() }}</td>
                      <td>
                        <button  class="btn btn-icon-only btn-danger rounded-circle removeCommitment" id="{{ $commitmentComplete->id }}">
                            <span class="btn-inner--icon"><i class="ni ni-fat-remove"></i></span>
                        </button>
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
            <div class="card-footer py-4">
              <nav aria-label="...">
                <ul class="pagination justify-content-end mb-0">

                  {{$getCommitment->links()}}


                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="addCommitment" tabindex="-1" role="dialog" aria-labelledby="addCommitmentLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form method="post" action="{{ route('addCommitment') }}">
            @csrf
            <div class="modal-body">
                <h6 class="heading-small text-muted mb-4">commitment details</h6>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label">Commitment</label>
                        <input type="text" name="title" class="form-control form-control-alternative" placeholder="Commitment" autocomplete="off" required>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                  <div class="col-lg-12">
                  <h3>Have Limit ? <br>
                  <small class="text-danger">if no limit amount of commitment</small></h3>
                  <label class="custom-toggle">
                    <input type="checkbox" checked="" id="isLimit">
                    <span class="custom-toggle-slider rounded-circle"></span>
                  </label>
                  <span class="clearfix"></span>
                  </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-4" id="boxTotal">
                      <div class="form-group">
                        <label class="form-control-label">Total</label>
                        <input type="number" name="total" step=0.01 class="form-control form-control-alternative" placeholder="Total " autocomplete="off" required>
                      </div>
                    </div>
                    <div class="col-lg-4" id="boxBalance">
                      <div class="form-group">
                        <label class="form-control-label">Balance</label>
                        <input type="number" name="balance" step=0.01 class="form-control form-control-alternative" placeholder="Balance " autocomplete="off" required>
                      </div>
                    </div>
                    <div class="col-lg-4" id="boxMonthly">
                      <div class="form-group">
                        <label class="form-control-label">Monthly</label>
                        <input type="number" name="monthly" step=0.01 class="form-control form-control-alternative" placeholder="Monthly" autocomplete="off" required>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="form-control-label" >Date : {{ \Carbon\Carbon::today()->format('d-m-Y') }}</label>
                        <p><small class="text-info"><strong>Info:</strong> <br>Have Limit - you know the total amount. <br> UnLimit - You pay until you done.</small></p>
                      </div>
                    </div>
                  </div>
                <hr class="my-1" />
            </div>
            <div class="modal-footer">
              <input type="hidden" name="limit" id="inputLimit" value="0">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Commitment update modal start -->
      <div class="modal fade" id="updateCommitmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form method="post" action="{{ route('updateCommitment') }}">
            @csrf
            <div class="modal-body">
                <div class="card-body">
                <h6 class="heading-small text-muted mb-4">Update Commitment</h6>
                <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label">Commitment</label>
                        <input type="text" name="title" id="forTitle" class="form-control form-control-alternative" placeholder="Commitment" autocomplete="off">
                      </div>
                    </div>
                  </div>
                
                  <div class="row">
                    <div class="col-lg-4" id="updateTotal">
                      <div class="form-group">
                        <label class="form-control-label">Total</label>
                        <input type="number" name="total" step=0.01 id="forTotal" class="form-control form-control-alternative" placeholder="Total " autocomplete="off" required>
                      </div>
                    </div>
                    <div class="col-lg-4" id="updateBalance">
                      <div class="form-group">
                        <label class="form-control-label">Balance</label>
                        <input type="number" name="balance" step=0.01 id="forBalance" class="form-control form-control-alternative" placeholder="Balance " autocomplete="off" required>
                      </div>
                    </div>
                    <div class="col-lg-4" id="updateMonthly">
                      <div class="form-group" >
                        <label class="form-control-label">Monthly</label>
                        <input type="number" name="monthly" step=0.01 id="forMonthly" class="form-control form-control-alternative" placeholder="Monthly" autocomplete="off" required>
                      </div>
                    </div>
                  </div>
            </div>
                <hr class="my-1" />
            </div>
            <div class="modal-footer">
              <input type="hidden" name="id" id="forId" >
              <input type="hidden" name="limit" id="forLimit">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-default">Update</button>
            </div>
            </form>
          </div>
        </div>
      </div>
      <!-- Commitment update modal end -->
@stop

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>

$( document ).ready(function() {

  $('#isLimit').change(function() {
        if($(this).is(':checked')) {
          //on = 0 = all need
          $('#inputLimit').val('0');

          $('#boxTotal').show();
          $('#boxBalance').show();
          $('#boxTotal input').prop('required', true);
          $('#boxBalance input').prop('required', true);

        } else {
          //off = 1 
          $('#inputLimit').val('1');

          $('#boxTotal').hide();
          $('#boxBalance').hide();

          $('#boxTotal input').val('0').prop('required', false);
          $('#boxBalance input').val('0').prop('required', false);
          
        }
    });

  $('.forceCompleteCommitment').click(function(){
    var id = $(this).attr("id");
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger'
      },
      buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
      title: 'Are you sure to force complete?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, Force Complete it!',
      cancelButtonText: 'No, cancel!',
      reverseButtons: true
    }).then((result) => {
      if (result.value) {
        redirect('/forceCompleteCommitment', {
            "_token": "{{ csrf_token() }}",
            id:id
          },
        );
      } else if (
        /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.cancel
      ) {
        swalWithBootstrapButtons.fire(
          'Cancelled',
          'Cancel Force Completed',
          'error'
        )
      }
    })
    
  });

  $(".updateCommitment").click(function(){
    var id = $(this).attr("id");

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
          $('#forTitle').val(data.title);
          $('#forTotal').val(data.total);
          $('#forBalance').val(data.balance);
          $('#forMonthly').val(data.monthly);
          $('#forId').val(data.id);
          $('#forLimit').val(data.unlimit);
          $('#updateCommitmentModal').modal('show');

          $('#updateTotal').show()
          $('#updateBalance').show()
          $('#updateTotal input').prop('required', true);
          $('#updateBalance input').prop('required', true);
        } else {
          $('#forTitle').val(data.title);
          $('#forMonthly').val(data.monthly);
          $('#forId').val(data.id);
          $('#forLimit').val(data.unlimit);
          $('#updateCommitmentModal').modal('show');

          $('#updateTotal').hide()
          $('#updateBalance').hide()

          $('#updateTotal input').val('0').prop('required', false);
          $('#updateBalance input').val('0').prop('required', false);
        }
      }
    });
  });

  $(".removeCommitment").click(function(){
    var id = $(this).attr("id");
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger'
      },
      buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel!',
      reverseButtons: true
    }).then((result) => {
      if (result.value) {
        redirect('/deleteCommitment', {
            "_token": "{{ csrf_token() }}",
            id:id
          },
        );
      } else if (
        /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.cancel
      ) {
        swalWithBootstrapButtons.fire(
          'Cancelled',
          'Cancel Delete',
          'error'
        )
      }
    })
  });  

  function redirect(url, data) {
    var form = document.createElement('form');
    document.body.appendChild(form);
    form.method = 'post';
    form.action = url;
    for (var name in data) {
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = data[name];
        form.appendChild(input);
    }
    form.submit();
}
});
</script>
@stop