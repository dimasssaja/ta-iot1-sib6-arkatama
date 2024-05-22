<!doctype html>
<html lang="en">
   <head>
    @include('layouts.dashboard._head')
   </head>
   <body>
      <!-- loader Start -->
      @include('layouts.dashboard.loader')
      <!-- loader END -->
      <!-- Wrapper Start -->
      <div class="wrapper">
         <!-- Sidebar  -->
         @include('layouts.dashboard.sidebar')
         <!-- TOP Nav Bar -->
         @include('layouts.dashboard.header')
         <!-- TOP Nav Bar END -->
         <!-- Page Content  -->
         <div id="content-page" class="content-page">
            <div class="container-fluid">
                    @yield('content')
            </div>
         </div>
      </div>
      <!-- Wrapper END -->
      <!-- Footer -->
      @include('layouts.dashboard.footer')
      <!-- Footer END -->

      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      @include('layouts.dashboard._foot')
   </body>
</html>
