<!-- Page Sidebar Start-->
<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper">
            <a href="{{ route('index') }}">
                <img class="img-fluid for-light" src="{{ url(@$setting->logoDark) }}" alt="">
                <img class="img-fluid for-dark" src="{{ url(@$setting->logo) }}" alt="">
            </a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"></i></div>
        </div>
        <div class="logo-icon-wrapper"><a href="{{ route('index') }}"><img class="img-fluid" src="{{ url(@$setting->logoDark) }}" alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"><a href="{{ route('index') }}"><img class="img-fluid" src="{{ url(@$setting->logoDark) }}" alt=""></a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="">Welcome!</h6>
                            <p class="">Greetings from {{ @$setting->companyName }}</p>
                        </div>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav active" href="{{ route('index') }}"><i data-feather="home"> </i><span>Dashboard</span></a></li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('customer.show') }}"><i data-feather="user"> </i><span>Customer</span></a></li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('contact.show') }}"><i data-feather="phone"> </i><span>Contacts</span></a></li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i data-feather="box"></i><span>Product</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('product.show') }}">Product List</a></li>
                            <li><a href="{{ route('variation.show') }}">Variation</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('order.show') }}"><i data-feather="eye"> </i><span>Order</span></a></li>
                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i data-feather="file-text"></i><span>Settings</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('userType.show') }}">User Type</a></li>
                            <li><a href="{{ route('category.show') }}">Category</a></li>
                            <li><a href="{{ route('banner.show') }}">Banner</a></li>
                            <li><a href="{{ route('brand.show') }}">Brand</a></li>
                            <li><a href="{{ route('unit.show') }}">Unit</a></li>
{{--                            <li><a href="{{ route('slider.show') }}">Slider</a></li>--}}
                            <li><a href="{{ route('menu.show') }}">Menu</a></li>
                            <li><a href="{{ route('page.show') }}">Pages</a></li>
                            <li><a href="{{ route('meta.show') }}">Meta</a></li>
                            <li><a href="{{ route('promotion.show') }}">Promotions</a></li>
                            {{-- <li><a href="{{ route('testimonial.show') }}">Testimonials</a></li> --}}
{{--                            <li><a href="{{ route('hotDeal.show') }}">Hot Deals</a></li>--}}
                            <li><a href="{{ route('setting.show') }}">Setting</a></li>
                        </ul>
                    </li>
{{--                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i data-feather="users"></i><span>Clients</span></a>--}}
{{--                        <ul class="sidebar-submenu">--}}
{{--                            <li><a href="./check-transaction.html">Check Transaction</a></li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
{{--                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="./invoice.html"><i data-feather="file-text"> </i><span>Invoice</span></a></li>--}}
{{--                    <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="#"><i data-feather="box"></i><span>Others</span></a>--}}
{{--                        <ul class="sidebar-submenu">--}}
{{--                            <li><a href="./manage-your-database.html">Manage Your Database</a></li>--}}
{{--                            <li><a href="./password-change.html">Password Change</a></li>--}}
{{--                            <li><a href="./schedule-sms-info.html">Schedule SMS Info</a></li>--}}
{{--                            <li><a href="./faq.html">FAQ</a></li>--}}
{{--                            <li><a href="./user-manual.html">User Manual</a></li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
{{--                    <li class="sidebar-main-title">--}}
{{--                        <div>--}}
{{--                            <h6>Thank You!</h6>--}}
{{--                            <p>For Using Our SMS Panel</p>--}}
{{--                        </div>--}}
{{--                    </li>--}}
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
<!-- Page Sidebar Ends-->
