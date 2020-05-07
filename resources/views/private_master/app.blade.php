<!DOCTYPE html>
<html lang="en">
   @include('private_master.head')
   <body>
   @include('private_master.sidebar')
   <div class="main-content">
   @include('private_master.navbar')
   @yield('top-header')
    <div class="container-fluid mt--7">
   @yield('content')


    @include('private_master.footer')
    </div>
   </div>
      @include('private_master.jscript')

      @yield('script')
   </body>
</html>
