@extends('private_master.app')

@section('top-header')
<!-- Header -->
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
        </div>
      </div>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col col-xl-6mb-5 mb-xl-0">
        <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Listing Income</h3>
            </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table align-items-center table-flush">
            <thead class="thead-light">
            <tr>
            <th scope="col">#</th>
            <th scope="col">title</th>
            <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @php
                $bil = 1;
            @endphp
            @if(count($incomeList) > 0)
                @foreach($incomeList as $income)
                    <tr>
                        <td>{{ $bil++ }}</td>
                        <td>{{ $income->title }}</td>
                        <td>
                        @if($income->fixed == 0)
                        <span class="badge badge-pill badge-danger text-uppercase">Fixed</span>
                        @else
                        <button  class="btn btn-icon-only btn-warning btn-sm rounded-circle forceCompleteCommitment" id="{{ $income->id }}" title="Complete">
                            <span class="btn-inner--icon"><i class="ni ni-settings"></i></span>
                        </button>
                        <button  class="btn btn-icon-only btn-danger btn-sm rounded-circle updateCommitment" title="Update" id="{{ $income->id }}">
                            <span class="btn-inner--icon"><i class="ni ni-fat-remove"></i></span>
                        </button>
                        @endif
                        </td>
                    <tr>
                @endforeach
            @endif
        </tbody>
            </table>
        </div>
        <div class="card-footer py-4">
            <nav aria-label="...">
            <ul class="pagination justify-content-end mb-0">
            </ul>
            </nav>
        </div>
        </div>
    </div>
    <div class="col col-xl-6mb-5 mb-xl-0">
        <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Listing Expenses</h3>
            </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table align-items-center table-flush">
            <thead class="thead-light">
            <tr>
            <th scope="col">#</th>
            <th scope="col">title</th>
            <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        @php
            $bil = 1;
        @endphp
        @if(count($expensesList) > 0)
            @foreach($expensesList as $expenses)
                <tr>
                    <td>{{ $bil++ }}</td>
                    <td>{{ $expenses->title }}</td>
                    <td>
                        @if($expenses->fixed == 0)
                        <span class="badge badge-pill badge-danger text-uppercase">Fixed</span>
                        @else
                        <button  class="btn btn-icon-only btn-warning btn-sm rounded-circle forceCompleteCommitment" id="{{ $expenses->id }}" title="Complete">
                            <span class="btn-inner--icon"><i class="ni ni-settings"></i></span>
                        </button>
                        <button  class="btn btn-icon-only btn-danger btn-sm rounded-circle updateCommitment" title="Update" id="{{ $expenses->id }}">
                            <span class="btn-inner--icon"><i class="ni ni-fat-remove"></i></span>
                        </button>
                        @endif
                        </td>
                <tr>
            @endforeach
        @endif
        </tbody>
            </table>
        </div>
        <div class="card-footer py-4">
            <nav aria-label="...">
            <ul class="pagination justify-content-end mb-0">
            </ul>
            </nav>
        </div>
        </div>
    </div>
</div>
@stop
