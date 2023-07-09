<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/fontawesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/css/login.css')}}">
  </head>
  <body>
    <div class="login-page">
      <div class="container">
          <div class="login-container">
             <div class="row">
               <div class="col-lg-6 col-md-6 col-12 left-section">
                 <div class="p-5">
                     <div class="left-header-text mt-4">
                         <h2 class="p-3 text-center fw-bold">{{ $content->company_name }}</h2>
                     </div>
                     <div class="left-section-img d-flex justify-content-center">
                       <img src="{{ asset($content->logo) }}" alt="login image">
                     </div>
                     <div class="company-section d-flex justify-content-center">
                       <!-- <a class="company-info text-black mt-3"><i class="fas fa-building"></i> Manage Your Ecommerce Business</a> -->
                     </div>
                     <div class="company-address mt-2">
                       <p class="text-center">Corporate Office : {{ $content->address }}</p>
                     </div>
                 </div>
               </div>
                <div class="col-lg-6 col-md-6 col-12 right-section">
                      <div class="mt-5 p-5">
                        <div class="right-text-h2">
                          <h2 class="fs-3 fw-bold">Login To Your Account</h2>
                          <!-- <p>Please Enter Your Login Details</p> -->
                        </div>
                     <form action="{{ route('login.check') }}" method="post"> 
                      @csrf
                          <label class="label-email mb-0" for="email">Username</label>
                          <div class="input-group">
                            <div class="">
                              <span class="input-group-text input-item"><i class="fas fa-envelope-square"></i></span>
                            </div>
                            <input type="text" name="username" class="form-control item">
                          </div>
                          <label class="label-password mb-0" for="password">Password</label>
                          <div class="input-group">
                            <div class="">
                              <span class="input-group-text input-item"><i class="fas fa-unlock"></i></span>
                            </div>
                            <input type="password" name="password" class="form-control item" placeholder="Your Password">
                          </div>
                          <div class="right-btn mt-3">
                          <input type="submit" class="login-btn" value="login">
                          </div>
                        </div>
                      </form>
                </div>
             </div>
          </div>
      </div>
    </div>
     <script src="{{asset('admin/js/jquery-3.6.0.min.js')}}"></script>
     <script src="{{asset('admin/js/bootstrap.min.js')}}"></script>
     <script src="{{asset('admin/js/frontawesome.js')}}"></script>
  </body>
</html>
