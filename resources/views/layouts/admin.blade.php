<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        
        <meta name="author" content="MD Sazzat Hossain" />
        <title>{{ $content->company_name }} | @yield('title')</title>
        <link rel="shortcut icon" href="{{ asset($content->logo) }}" type="image/x-icon">
        <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('admin/css/dataTabel.css') }}" rel="stylesheet" />
        <link href="{{ asset('admin/css/styles.css') }}" rel="stylesheet" />
        <link href="{{ asset('admin/css/custom.css') }}" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="{{asset('admin/css/invoice.css')}}">
        @stack('admin-css')
    </head>
    <body class="sb-nav-fixed fixed-footer"  onload="startTime()">
        @include('partials.admin_navbar')
        <div id="layoutSidenav">  
        
            @include('partials.admin_sidebar')
            <div id="layoutSidenav_content">
                 <div class="container mt-4">
                     @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif

                    @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif

                    @if ($message = Session::get('warning'))
                    <div class="alert alert-warning alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif

                    @if ($message = Session::get('info'))
                    <div class="alert alert-info alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message}}</strong>
                    </div>
                    @endif
                    @if ($message = Session::get('delete_check'))
                    <div class="alert alert-info alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message}}</strong>
                    </div>
                    @endif

                    @if ($message = Session::get('delete'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message}}</strong>
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger alert-block">
                        @foreach ($errors->all() as $error)
                            <div>{{$error}}</div>
                        @endforeach
                    </div>
                    @endif
                    
                @yield('admin-content') 
                @include('partials.admin_footer')
            </div>
        </div>
        <script src="{{ asset('admin/js/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('admin/js/scripts.js') }}"></script>
        <script src="{{ asset('admin/js/vue.js') }}"></script>
        <script src="{{ asset('admin/js/vue-select.js') }}"></script>
        <script src="{{ asset('admin/js/axios.min.js') }}"></script>
        <script src="{{ asset('admin/js/simple-datatables@latest.js') }}"></script>
        <script src="{{ asset('admin/js/datatables-simple-demo.js') }}"></script>
        <script src="{{ asset('admin/js/select2.min.js') }}"></script>
        <script src="{{ asset('admin/js/all.min.js') }}"></script>
        <script>
            function startTime() {
              const today = new Date();
              const days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
              const months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
              let d = today.getDay();
              let date = today.getDay();
              let h = today.getHours();
              let m = today.getMinutes();
              let s = today.getSeconds();
              m = checkTime(m);
              s = checkTime(s);
              document.getElementById('txt').innerHTML =days[today.getDay()]+','+' '+today.getDate()+' '+months[today.getMonth()]+' '+today.getFullYear()+','+' '+h + ":" + m + ":" + s;
              setTimeout(startTime, 1000);
            }
            function checkTime(i) {
              if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
              return i;
            }
            </script>
        <script>
            $("document").ready(function(){
              setTimeout(function(){
              $("div.alert").fadeOut();
              }, 3000 ); // 5 secs

              $('.js-example-basic-multiple').select2();
          });
      </script>
     
      <script>
          window.addEventListener('DOMContentLoaded', event => {
          // Simple-DataTables
          // https://github.com/fiduswriter/Simple-DataTables/wiki
      
          const datatablesSimple = document.getElementById('first_table');
          if (datatablesSimple) {
              new simpleDatatables.DataTable(datatablesSimple);
          }
          const confirmTable = document.getElementById('confirm');
          if (confirmTable) {
              new simpleDatatables.DataTable(confirmTable);
          }
          });
      </script>
        @stack('admin-js')
    </body>
</html>
