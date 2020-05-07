@extends('private_master.app')

@section('top-header')
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
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">List Transaction</h3>
                </div>
              </div>
            </div>
            <div class="table-responsive">
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
            @foreach($getTransaction as $transaction)
            <tr>
                <th>{{ $d++ }}</th>
                <th scope="row">{{ $transaction->log_reason }}</th>
                <th scope="row">{{$transaction->lookup->title}}</th>
                <td><i class="fas {{ ($transaction->lookup->getMaster() == 2) ? 'fa-arrow-up text-success' : 'fa-arrow-down text-warning' }} mr-3"></i>RM {{$transaction->log_rm}}</td>
                <td>{{$transaction->created_at->diffForHumans()}}</td>
            </tr>
            @endforeach
                
            </tbody>
              </table>
            </div>
            <div class="card-footer py-4">
              <nav aria-label="...">
                <ul class="pagination justify-content-end mb-0">

                  {{$getTransaction->links()}}


                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
@stop
