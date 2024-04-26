<footer class="">
    <div class="footer-top pt-80 pb-50">
      <div class="container">
        <div class="row justify-content-between">
          <div class="col-sm-6 col-md-4 mb-3 mb-lg-0">
            <div class="logo-box">
              <a href="#">
                @isset($setting->logo)
                <img src="{{ url('admin/'. @$setting->logo) }}" alt="logo" class="img-fluid mb-2">
                @endisset
              </a>
              <p class="mt-3">{{@$setting->contactText2 }}</p>
              <ul class="social-icons d-flex gap-3 mt-3 mt-lg-4">
                <li>
                  <a href="{{ @$setting->facebook }}" class="text-white"><i class="fa-brands fa-facebook"></i></a>
                </li>
                <li>
                  <a href="{{ @$setting->twitter }}" class="text-white"><i class="fa-brands fa-twitter"></i></a>
                </li>
                <li>
                  <a href="{{ @$setting->instagram }}" class="text-white"><i class="fa-brands fa-instagram"></i></a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-sm-6 col-lg-2 mb-3 mb-lg-0">
            <div class="link-box">
              <h5 class="text-white">Product</h5>
              <ul>
                
                <li>
                  <a href="{{ route('index') }}">Home</a>
                </li>
                <li>
                  <a href="{{ route('shop') }}">Shop</a>
                </li>               
              </ul>
            </div>
          </div>
          <div class="col-sm-6 col-lg-2 mb-3 mb-lg-0">
            <div class="link-box">
              <h5 class="text-white">Resource</h5>
              <ul>
                @if(!empty($resourceMenus))
                @foreach($resourceMenus as $footerMenu)
                
                <li>
                  <a href="{{ route('page', $footerMenu->fkPageId) }}">{{ $footerMenu->menuName }}</a>
                </li>
              
                @endforeach
                @endif    
              </ul>
            </div>
          </div>
          <div class="col-sm-6 col-lg-2">
            <div class="link-box">
              <h5 class="text-white">Contact Us</h5>
              <ul>
                @if(!empty($contactMenus))
                @foreach($contactMenus as $footerMenu)
                
                <li>
                  <a href="{{ route('page', $footerMenu->fkPageId) }}">{{ $footerMenu->menuName }}</a>
                </li>
              
                @endforeach
                @endif               
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="footer-bottom py-3 py-lg-4 border-top">
      <div class="container">
        <p class="text-center">© {{ date('Y') }} <a href="{{url('/') }}" class="text-red">{{ @$setting->companyName }}</a>. All Rights Reserved</p>
        {{-- <li>© {{ date('Y') }}. All rights reserved by <a target="_blank" href="{{ route('index') }}">{{ @$setting->companyName }}</a>.</li> --}}
      </div>
    </div>
  </footer>