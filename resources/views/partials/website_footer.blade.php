 <!-- footer first -->
 <footer class="footer-bg footer-border-bottom">
     <div class="container pt-4">
         <div class="row mb-4">
             <div class="col-lg-12 col-md-12 col-12">
                <div class="text-capitalize text-center text-white">we accept</div>
                 <div class="vertical-align justify-content-center"> 
                     <div><a href=""><img src="{{ asset('website') }}/img/bkash_logo_0.jpg" alt=""
                                 class="payment-img rounded"></a></div>
                     <div><a href=""><img src="{{ asset('website') }}/img/rocket.png" alt=""
                                 class="payment-img rounded"></a></div>
                     <div><a href=""><img src="{{ asset('website') }}/img/dbbl.jpg" alt=""
                                 class="payment-img rounded"></a></div>
                     <div><a href=""><img src="{{ asset('website') }}/img/visa.png" alt=""
                                 class="payment-img rounded"></a></div>
                     <div><a href=""><img src="{{ asset('website') }}/img/mastercard.jpg" alt=""
                                 class="payment-img rounded"></a></div>
                     <div><a href=""><img src="{{ asset('website') }}/img/paypal.png" alt=""
                                 class="payment-img rounded"></a></div>
                 </div>
             </div>
         </div>
         <div class="row">
             <div class="col-lg-3 col-md-3 col-12 ">
                 <div class="footer-title">
                     <h3>Contact us</h3>
                 </div>
                 <ul class="fa-ul custom-fa-ul">
                     <li><a href=""> <i class="fas fa-map-marker-alt pe-2"></i>{{ $content->address }}</a></li>
                     <li><a href=""><i class="fas fa-phone pe-2"></i>{{ $content->phone_1 }}</a></a></li>
                     <li><a href=""><i class="fas fa-phone pe-2"></i>{{ $content->phone_2 }}</a></a></li>
                     <li><a href=""><i class="fas fa-envelope pe-2"></i>{{ $content->email }}</a></a></li>
                 </ul>
             </div>
             <div class="col-lg-3 col-md-3 col-12 ">
                 <div class="footer-title">
                     <h3>User Information</h3>
                 </div>
                <ul class="footer-quick-links ms-0 link-icon mb-3">
                    <li><a href="{{ route('aboutUs.website') }}" target="_blank"><i class="fas fa-angle-right fa-fw"></i><span>About Us</span></a></li>
                    <li><a href="{{ route('contact.website') }}" target="_blank"><i class="fas fa-angle-right fa-fw"></i><span>Contact Us</span></a></li>
                    <li><a href="{{ route('customer.dashboard') }}" target="_blank"><i class="fas fa-angle-right fa-fw"></i><span>My Account</span></a></li>
                    <li><a href="{{ route('cart.list') }}" target="_blank"><i class="fas fa-angle-right fa-fw"></i><span>Cart List</span></a></li>
                    <li><a href="{{ route('checkout') }}" target="_blank"><i class="fas fa-angle-right fa-fw"></i><span>Checkout</span></a></li>
                    <li><a href="{{ route('customer.login') }}" target="_blank"><i class="fas fa-angle-right fa-fw"></i><span>Login</span></a></li>
                </ul>
             </div>

             <div class="col-lg-2 col-md-2 col-12 ">
                 <div class="footer-title">
                     <h3>Quick Link</h3>
                 </div>
                 <ul class="footer-quick-links ms-0 link-icon">
                    <li><a href="{{ route('website.track') }}" target="_blank"><i class="fas fa-angle-right fa-fw"></i><span>Live Traking Order</span></a></li>
                    <li><a href="{{ route('mission.website') }}"><i class="fas fa-angle-right fa-fw"></i><span>Mission and Vission</span></a></li>
                    <li><a href="{{ route('trams.website') }}"><i class="fas fa-angle-right fa-fw"></i><span>Terms and Condition</span></a></li>
                    <li><a href="{{ route('store.list') }}"><i class="fas fa-angle-right fa-fw"></i><span>Store Location</span></a></li>
                    <li><a target="_blank" href="{{ route('sizeGuide.web') }}"><i class="fas fa-angle-right fa-fw"></i><span>Size Guide</span></a></li>
                    <li><a href="{{ route('management.website') }}"><i class="fas fa-angle-right fa-fw"></i><span>Our Management</span></a></li>
                </ul>
             </div>

             <div class="col-lg-2 col-md-2 col-12">
                 <div class="footer-title">
                     <h3>Product Category</h3>
                 </div>
                 <ul class="footer-quick-links ms-0 link-icon">
                     @foreach ($randCategory as $item)
                         <li><a target="_blank" href="{{ route('categroy.product', $item->slug) }}"><i class="fas fa-angle-right fa-fw"></i><span>{{ $item->name }}</span></a></li>
                         @endforeach
                         
                 </ul>
                 <div>
                    
                 </div>
             </div>
              <div class="col-lg-2 col-md-2 col-12">
                
                 
                 <div class="download_img"> <a  target="_blank" href="{{asset('bornon.apk')}}"  download><img src="{{ asset('wt11-gif.gif') }}" style="height: 60px; widht:80px" alt=""> </a> </div>
             </div>
         </div>
     </div>
 </footer>
 <!-- close footer first -->

 <!-- second footer -->
 <footer class="footer-bg">
     <div class="container py-1">
         <div class="row">
             <div class="col-12">
                 <div class="d-flex justify-content-between">
                     <div class=""><span class="developed-text">Developed By:</span>&nbsp;<a
                             class="linkup-link" href="https://linktechbd.com/" target="_blank">Link-Up Technology
                             Ltd.</a></div>
                     <div class="d-flex gap-3">
                         <a href="{{ $content->facebook }}"><i class="fa-brands fa-facebook-f text-white"></i></a>
                         <a href="{{ $content->instagram }}"><i class="fa-brands fa-instagram text-white"></i></a>
                         <a href="{{ $content->linkedin }}"><i class="fa-brands fa-twitter text-white"></i></a>
                         <a href="{{ $content->youtube }}"><i class="fa-brands fa-youtube text-white"></i></a>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </footer>
