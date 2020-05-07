@extends('private_master.app')

@section('top-header')
<!-- Header -->
<div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 600px; background-image: url({{ asset('store/61.jpg') }}); background-size: cover; background-position: center top;">
      <!-- Mask -->
      <span class="mask bg-gradient-default opacity-8"></span>
      <!-- Header container -->
      <div class="container-fluid d-flex align-items-center">
        <div class="row">
          <div class="col-lg-7 col-md-10">
            <h1 class="display-2 text-white">Hello {{ $user->name }}</h1>
            <p class="text-white mt-0 mb-5">Thank you for using "jimbo debt", any problem can directly report at <a href="" class="text-warning"><strong>noorhazimesa@gmail.com</strong></a></p>
          </div>
        </div>
      </div>
    </div>
@stop

@section('content')
@include('sweetalert::alert')
<!-- Page content -->
      <div class="row">
        <div class="col-xl-12 order-xl-2 mb-5 mb-xl-0">
          <div class="card card-profile shadow">
            <div class="row justify-content-center">
              <div class="col-lg-3 order-lg-2">
                <div class="card-profile-image">
                  <a href="#">
                    <img src="{{ asset('store/admin2.png') }}" class="rounded-circle">
                  </a>
                </div>
              </div>
            </div>
            <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
              <div class="d-flex justify-content-between">
                <a href="#" class="btn btn-sm btn-default mr-4" data-toggle="modal" data-target="#exampleModal">Edit Profile</a>
                <a href="#" class="btn btn-sm btn-danger float-right" data-toggle="modal" data-target="#exampleModal1">Change Password</a>
              </div>
            </div>
            <div class="card-body pt-0 pt-md-4">
              <div class="row">
                <div class="col">
                  <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                    <div>
                    @if($user->userDetails == null)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <span class="alert-inner--text"><strong>Mandatory!</strong> Update your current money. Click 'Edit Profile'</span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    @endif
                      <span class="heading">RM {{ ($user->userDetails != null) ? $user->userDetails->money : '-' }}</span>
                      <span class="description">Current Money</span>
                    </div>
                    
                  </div>
                </div>
              </div>
              <div class="text-center">
              <h3>
                  {{ $user->name }}<span class="font-weight-light">| {{ \Carbon\Carbon::parse($user->created_at)->format('d, M Y') }}</span>
                </h3>
                <div class="h5 font-weight-300">
                  <i class="ni location_pin mr-2"></i>{{ $user->email }}
                </div>
                <div class="h5 mt-4">
                  <i class="ni business_briefcase-24 mr-2"></i>'Beware of Little Expenses, a small leak will sink a great ship'
                </div>
                <div>
                  <i class="ni education_hat mr-2"></i>- Benjamin Franklin -
                </div>
                <hr class="my-4" />
                <p></p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- profile update modal start -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form method="post" action="{{ route('editProfile') }}" name="editProfile">
            @csrf
            <div class="modal-body">
                <div class="card-body">
                <h6 class="heading-small text-muted mb-4">Update Profile</h6>
                @if($user->userDetails == null)
                <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label text-danger" >Current Money (RM)</label>
                        <input type="number" name="money" step="0.01" class="form-control form-control-alternative" placeholder="Current Money" value="" autocomplete="off" required>
                        <small class="text-danger">Please Make sure current money included balance in your bank Account. Once you key in your current money, you cannot edit</small>
                      </div>
                    </div>
                  </div>
                @endif
                <div class="row">
                  <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label" for="input-username">Name</label>
                        <input type="text" name="name" class="form-control form-control-alternative" placeholder="Name" value="{{ $user->name }}" autocomplete="off" required>
                      </div>
                    </div>
                </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label" for="input-first-name">If you want change your email or current money, Please directly email to <a class="text-warning">noorhazimesa@gmail.com</a></label>
                        
                      </div>
                    </div>
                  </div>
            </div>
                <hr class="my-1" />
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-default">Update</button>
            </div>
            </form>
          </div>
        </div>
      </div>
      <!-- profile update modal end -->

      <!-- password update modal start -->
      <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form method="post" action="{{ Route('resetPassword') }}">
            @csrf
            <div class="modal-body">
                <div class="card-body">
                <h6 class="heading-small text-muted mb-4">Update Password</h6>
                <div class="row">
                  <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label">Current Password</label>
                        <input type="password" name="currentpass" class="form-control form-control-alternative" placeholder="Current Password" value="" required>
                      </div>
                    </div>
                </div>
                <hr class="my-4" />
                  <div class="row">
                  <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label">New Password</label>
                        <input  id="password"type="password" name="password" class="form-control form-control-alternative" placeholder="New Password" value="" required>
                        <small class="text-danger" id="msgMinPass">Minimum password at least 8 character</small>
                      </div>
                    </div>
                </div>
                  <div class="row">
                  <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control form-control-alternative" placeholder="Confirm Password" value="" required>
                      </div>
                    </div>
                </div>
            </div>
                <hr class="my-1" />
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger" >Confirm Update</button>
            </div>
            </form>
          </div>
        </div>
      </div>
      <!-- password update modal end -->
@stop

@section('script')
<script>
    $(document).ready(function(){
      var strokeCount = 0;
      var total;
      $('#password').keyup(function(){
        total = $(this).val().length;
        if(total >= 8){
          $('#msgMinPass').text('Good').removeClass('text-danger').addClass('text-success');
        } else {
          $('#msgMinPass').text('Minimum password at least 8 character').removeClass('text-success').addClass('text-danger');
        }
      });
    });

    </script>
@stop