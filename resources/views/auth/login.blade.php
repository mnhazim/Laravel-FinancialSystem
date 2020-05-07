<html lang="en"><head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Jiembo - mnhazim
  </title>
  <meta name="keywords" content="financial system laravel php mysql">
<meta name="description" content="Beware of Little Expenses, a small leak will sink a great ship">
<meta name="author" content="mnhazim">
<link rel="canonical" href="https://finance.mnhazim.com/" />

<meta property="og:type" content="Financial System using laravel" />
<meta property="og:title" content="Financial System using laravel" />
<meta property="og:description" content="Beware of Little Expenses, a small leak will sink a great ship" />
<meta property="og:url" content="https://finance.mnhazim.com" />
<meta property="og:site_name" content="mnhazim" />
<meta property="article:section" content="Hazim Esa" />
<meta property="article:published_time" content="2020-05-05 00:00:00" />
<meta property="article:modified_time" content="2020-05-05 18:23:12" />
<meta property="og:image" content="{{ asset('store/logo1.png') }}" />

<meta name="twitter:card" content="Hazim Esa" />
<meta name="twitter:title" content="Hazim Esa" />
<meta name="twitter:description" content="Beware of Little Expenses, a small leak will sink a great ship" />
<meta name="twitter:image" content="{{ asset('store/logo1.png') }}" />
<meta name="twitter:site" content="@mnhazim__">
<meta name="twitter:creator" content="@mnhazim__">
<meta name="twitter:url" content="https://finance.mnhazim.com" />
  <link href="{{ asset('store/admin2.png') }}" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="{{ asset('theme/js/plugins/nucleo/css/nucleo.css') }}" rel="stylesheet" />
  <link href="{{ asset('theme/js/plugins/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="{{ asset('theme/css/argon-dashboard.css?v=1.1.0') }}" rel="stylesheet" />
</head>
<body class="bg-default" cz-shortcut-listen="true">
@include('sweetalert::alert')
  <div class="main-content">
    <!-- Navbar -->
    <nav class="navbar navbar-top navbar-horizontal navbar-expand-md navbar-dark">
      <div class="container px-4">
        <a class="navbar-brand" href="/">
          <img src="store/logo1.png">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar-collapse-main">
          <!-- Collapse header -->
          <div class="navbar-collapse-header d-md-none">
            <div class="row">
              <div class="col-6 collapse-brand">
                <a href="/">
                  <img src="store/logo1.png">
                </a>
              </div>
              <div class="col-6 collapse-close">
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                  <span></span>
                  <span></span>
                </button>
              </div>
            </div>
          </div>
          <!-- Navbar items -->
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link nav-link-icon" href="#">
                <i class="ni ni-planet"></i>
                <span class="nav-link-inner--text">Demo</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>    <!-- Header -->
    <div class="header bg-gradient-primary py-7 py-lg-8">
      <div class="container">
        <div class="header-body text-center mb-3">
          <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6">
              <h1 class="text-white">Welcome!</h1>
              <p class="text-lead text-light">"Record for your future! Register NOW"</p>
            </div>
          </div>
        </div>
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card bg-secondary shadow border-0">
            <div class="card-body px-lg-5 py-lg-5">
              <div class="text-center text-muted mb-4">
                <small>Sign in with credentials</small>
              </div>
              <form role="form" method="post" action="{{ route('login') }}">
              @if ($errors->any())
          <div class="alert alert-danger" role="alert">
            <span data-feather="alert-circle"></span><strong>&nbsp;Opps!</strong>, Serious bro?. Any Problem?
          </div>
        @endif
                @csrf
                <div class="form-group mb-3">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input class="form-control" placeholder="Email" type="email" name="email" required autocomplete="off">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input class="form-control is-invalid" placeholder="Password" type="password" name="password" required autocomplete="off">
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary my-4">Sign in</button>
                  <a type="button" data-toggle="modal" data-target="#newRegister" class="btn btn-danger my-4" href="/register" >Register</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="newRegister" tabindex="-1" role="dialog" aria-labelledby="newRegisterLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form method="post" action="{{ route('register') }}">
            @csrf
            <div class="modal-body">
                <h6 class="heading-small text-muted mb-4">New Register</h6>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label">{{ __('Name') }}</label>
                        <input type="text" name="name" class="form-control form-control-alternative" placeholder="Nick Name" autocomplete="off" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label">{{ __('E-Mail Address') }}</label>
                        <input type="email" name="email" class="form-control form-control-alternative" placeholder="Email Address " autocomplete="off" required>
                      </div>
                    </div>
                    </div>

                    <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group ">
                        <label class="form-control-label ">{{ __('Password') }}</label>
                        <input id="password" type="password" name="password" class="form-control form-control-alternative" placeholder="Password " autocomplete="off" required>
                        <small class="text-danger" id="msgMinPass">Minimum password at least 8 character</small>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" name="password_confirmation" class="form-control form-control-alternative" placeholder="Confirm Password" autocomplete="off" required>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="form-control-label" >Date : {{ \Carbon\Carbon::today()->format('d-m-Y') }}</label>
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


    <footer class="py-1">
      <div class="container">
        <div class="row align-items-center justify-content-xl-between">
          <div class="col-xl-6">
            <div class="copyright text-center text-xl-left text-muted">
              © 2018 <a href="https://www.creative-tim.com" class="font-weight-bold ml-1" target="_blank">Creative Tim</a>
            </div>
          </div>
          <div class="col-xl-6">
            <ul class="nav nav-footer justify-content-center justify-content-xl-end">
              <li class="nav-item">
                <a href="#" class="nav-link" target="_blank">mnhazim</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>  </div>
  <!--   Core   -->
    <script src="{{ asset('theme/js/plugins/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('theme/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!--   Optional JS   -->
    <script src="{{ asset('theme/js/plugins/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('theme/js/plugins/chart.js/dist/Chart.extension.js') }}"></script>
    <!--   Argon JS   -->
    <script src="{{ asset('theme/js/argon-dashboard.min.js?v=1.1.0') }}"></script>
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
</body></html>