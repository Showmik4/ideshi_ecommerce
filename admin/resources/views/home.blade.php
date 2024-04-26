@extends('layouts.main')

@section('main.content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>Dashboard</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}"><i data-feather="home"></i></a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row second-chart-list third-news-update">
                <div class="col-xl-12 xl-100 chart_data_left box-col-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="row m-0 chart-main">
                                <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                                    <div class="media align-items-center">
                                        <div class="hospital-small-chart">
                                            <div class="small-bar">
                                                <div class="small-chart flot-chart-container"><div class="chartist-tooltip"></div><svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-bar" style="width: 100%; height: 100%;"><g class="ct-grids"></g><g><g class="ct-series ct-series-a"><line x1="13.571428571428571" x2="13.571428571428571" y1="69" y2="58.2" class="ct-bar" ct:value="400" style="stroke-width: 3px"></line><line x1="20.714285714285715" x2="20.714285714285715" y1="69" y2="44.7" class="ct-bar" ct:value="900" style="stroke-width: 3px"></line><line x1="27.857142857142858" x2="27.857142857142858" y1="69" y2="47.4" class="ct-bar" ct:value="800" style="stroke-width: 3px"></line><line x1="35" x2="35" y1="69" y2="42" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line><line x1="42.14285714285714" x2="42.14285714285714" y1="69" y2="50.1" class="ct-bar" ct:value="700" style="stroke-width: 3px"></line><line x1="49.285714285714285" x2="49.285714285714285" y1="69" y2="36.6" class="ct-bar" ct:value="1200" style="stroke-width: 3px"></line><line x1="56.42857142857143" x2="56.42857142857143" y1="69" y2="60.9" class="ct-bar" ct:value="300" style="stroke-width: 3px"></line></g><g class="ct-series ct-series-b"><line x1="13.571428571428571" x2="13.571428571428571" y1="58.2" y2="31.200000000000003" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line><line x1="20.714285714285715" x2="20.714285714285715" y1="44.7" y2="31.200000000000003" class="ct-bar" ct:value="500" style="stroke-width: 3px"></line><line x1="27.857142857142858" x2="27.857142857142858" y1="47.4" y2="31.199999999999996" class="ct-bar" ct:value="600" style="stroke-width: 3px"></line><line x1="35" x2="35" y1="42" y2="31.200000000000003" class="ct-bar" ct:value="400" style="stroke-width: 3px"></line><line x1="42.14285714285714" x2="42.14285714285714" y1="50.1" y2="31.200000000000003" class="ct-bar" ct:value="700" style="stroke-width: 3px"></line><line x1="49.285714285714285" x2="49.285714285714285" y1="36.6" y2="31.200000000000003" class="ct-bar" ct:value="200" style="stroke-width: 3px"></line><line x1="56.42857142857143" x2="56.42857142857143" y1="60.9" y2="31.199999999999996" class="ct-bar" ct:value="1100" style="stroke-width: 3px"></line></g></g><g class="ct-labels"></g></svg></div>
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <div class="right-chart-content">
                                                <h4>{{$order}}</h4><span>Total Order</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                                    <div class="media align-items-center">
                                        <div class="hospital-small-chart">
                                            <div class="small-bar">
                                                <div class="small-chart1 flot-chart-container"><div class="chartist-tooltip" style="top: -8px; left: 30.3125px;"><span class="chartist-tooltip-value">1200</span></div><svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-bar" style="width: 100%; height: 100%;"><g class="ct-grids"></g><g><g class="ct-series ct-series-a"><line x1="13.571428571428571" x2="13.571428571428571" y1="69" y2="58.2" class="ct-bar" ct:value="400" style="stroke-width: 3px"></line><line x1="20.714285714285715" x2="20.714285714285715" y1="69" y2="52.8" class="ct-bar" ct:value="600" style="stroke-width: 3px"></line><line x1="27.857142857142858" x2="27.857142857142858" y1="69" y2="44.7" class="ct-bar" ct:value="900" style="stroke-width: 3px"></line><line x1="35" x2="35" y1="69" y2="47.4" class="ct-bar" ct:value="800" style="stroke-width: 3px"></line><line x1="42.14285714285714" x2="42.14285714285714" y1="69" y2="42" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line><line x1="49.285714285714285" x2="49.285714285714285" y1="69" y2="36.6" class="ct-bar" ct:value="1200" style="stroke-width: 3px"></line><line x1="56.42857142857143" x2="56.42857142857143" y1="69" y2="55.5" class="ct-bar" ct:value="500" style="stroke-width: 3px"></line></g><g class="ct-series ct-series-b"><line x1="13.571428571428571" x2="13.571428571428571" y1="58.2" y2="31.200000000000003" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line><line x1="20.714285714285715" x2="20.714285714285715" y1="52.8" y2="31.199999999999996" class="ct-bar" ct:value="800" style="stroke-width: 3px"></line><line x1="27.857142857142858" x2="27.857142857142858" y1="44.7" y2="31.200000000000003" class="ct-bar" ct:value="500" style="stroke-width: 3px"></line><line x1="35" x2="35" y1="47.4" y2="31.199999999999996" class="ct-bar" ct:value="600" style="stroke-width: 3px"></line><line x1="42.14285714285714" x2="42.14285714285714" y1="42" y2="31.200000000000003" class="ct-bar" ct:value="400" style="stroke-width: 3px"></line><line x1="49.285714285714285" x2="49.285714285714285" y1="36.6" y2="31.200000000000003" class="ct-bar" ct:value="200" style="stroke-width: 3px"></line><line x1="56.42857142857143" x2="56.42857142857143" y1="55.5" y2="31.200000000000003" class="ct-bar" ct:value="900" style="stroke-width: 3px"></line></g></g><g class="ct-labels"></g></svg></div>
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <div class="right-chart-content">
                                                <h4>{{$client}}</h4><span>Total Client</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                                    <div class="media align-items-center">
                                        <div class="hospital-small-chart">
                                            <div class="small-bar">
                                                <div class="small-chart2 flot-chart-container"><div class="chartist-tooltip" style="top: 5px; left: 20.625px;"><span class="chartist-tooltip-value">1000</span></div><svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-bar" style="width: 100%; height: 100%;"><g class="ct-grids"></g><g><g class="ct-series ct-series-a"><line x1="13.571428571428571" x2="13.571428571428571" y1="69" y2="39.3" class="ct-bar" ct:value="1100" style="stroke-width: 3px"></line><line x1="20.714285714285715" x2="20.714285714285715" y1="69" y2="44.7" class="ct-bar" ct:value="900" style="stroke-width: 3px"></line><line x1="27.857142857142858" x2="27.857142857142858" y1="69" y2="52.8" class="ct-bar" ct:value="600" style="stroke-width: 3px"></line><line x1="35" x2="35" y1="69" y2="42" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line><line x1="42.14285714285714" x2="42.14285714285714" y1="69" y2="50.1" class="ct-bar" ct:value="700" style="stroke-width: 3px"></line><line x1="49.285714285714285" x2="49.285714285714285" y1="69" y2="36.6" class="ct-bar" ct:value="1200" style="stroke-width: 3px"></line><line x1="56.42857142857143" x2="56.42857142857143" y1="69" y2="60.9" class="ct-bar" ct:value="300" style="stroke-width: 3px"></line></g><g class="ct-series ct-series-b"><line x1="13.571428571428571" x2="13.571428571428571" y1="39.3" y2="31.199999999999996" class="ct-bar" ct:value="300" style="stroke-width: 3px"></line><line x1="20.714285714285715" x2="20.714285714285715" y1="44.7" y2="31.200000000000003" class="ct-bar" ct:value="500" style="stroke-width: 3px"></line><line x1="27.857142857142858" x2="27.857142857142858" y1="52.8" y2="31.199999999999996" class="ct-bar" ct:value="800" style="stroke-width: 3px"></line><line x1="35" x2="35" y1="42" y2="31.200000000000003" class="ct-bar" ct:value="400" style="stroke-width: 3px"></line><line x1="42.14285714285714" x2="42.14285714285714" y1="50.1" y2="31.200000000000003" class="ct-bar" ct:value="700" style="stroke-width: 3px"></line><line x1="49.285714285714285" x2="49.285714285714285" y1="36.6" y2="31.200000000000003" class="ct-bar" ct:value="200" style="stroke-width: 3px"></line><line x1="56.42857142857143" x2="56.42857142857143" y1="60.9" y2="31.199999999999996" class="ct-bar" ct:value="1100" style="stroke-width: 3px"></line></g></g><g class="ct-labels"></g></svg></div>
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <div class="right-chart-content">
                                                <h4>{{$product}}</h4><span>Total Product</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
                                    <div class="media border-none align-items-center">
                                        <div class="hospital-small-chart">
                                            <div class="small-bar">
                                                <div class="small-chart3 flot-chart-container"><div class="chartist-tooltip"></div><svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-bar" style="width: 100%; height: 100%;"><g class="ct-grids"></g><g><g class="ct-series ct-series-a"><line x1="13.571428571428571" x2="13.571428571428571" y1="69" y2="58.2" class="ct-bar" ct:value="400" style="stroke-width: 3px"></line><line x1="20.714285714285715" x2="20.714285714285715" y1="69" y2="52.8" class="ct-bar" ct:value="600" style="stroke-width: 3px"></line><line x1="27.857142857142858" x2="27.857142857142858" y1="69" y2="47.4" class="ct-bar" ct:value="800" style="stroke-width: 3px"></line><line x1="35" x2="35" y1="69" y2="42" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line><line x1="42.14285714285714" x2="42.14285714285714" y1="69" y2="50.1" class="ct-bar" ct:value="700" style="stroke-width: 3px"></line><line x1="49.285714285714285" x2="49.285714285714285" y1="69" y2="39.3" class="ct-bar" ct:value="1100" style="stroke-width: 3px"></line><line x1="56.42857142857143" x2="56.42857142857143" y1="69" y2="60.9" class="ct-bar" ct:value="300" style="stroke-width: 3px"></line></g><g class="ct-series ct-series-b"><line x1="13.571428571428571" x2="13.571428571428571" y1="58.2" y2="31.200000000000003" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line><line x1="20.714285714285715" x2="20.714285714285715" y1="52.8" y2="39.3" class="ct-bar" ct:value="500" style="stroke-width: 3px"></line><line x1="27.857142857142858" x2="27.857142857142858" y1="47.4" y2="31.199999999999996" class="ct-bar" ct:value="600" style="stroke-width: 3px"></line><line x1="35" x2="35" y1="42" y2="33.9" class="ct-bar" ct:value="300" style="stroke-width: 3px"></line><line x1="42.14285714285714" x2="42.14285714285714" y1="50.1" y2="31.200000000000003" class="ct-bar" ct:value="700" style="stroke-width: 3px"></line><line x1="49.285714285714285" x2="49.285714285714285" y1="39.3" y2="33.9" class="ct-bar" ct:value="200" style="stroke-width: 3px"></line><line x1="56.42857142857143" x2="56.42857142857143" y1="60.9" y2="31.199999999999996" class="ct-bar" ct:value="1100" style="stroke-width: 3px"></line></g></g><g class="ct-labels"></g></svg></div>
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <div class="right-chart-content">
                                                <h4>{{$category}}</h4><span>Total Category</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="card o-hidden">
                        <a href="{{route('order.show')}}">
                        <div class="bg-primary b-r-4 card-body">
                            <div class="media static-top-widget">
                                <div class="align-self-center text-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg></div>
                                <div class="media-body"><span class="m-0">Orders</span>
                                    <h4 class="mb-0 counter">{{$order}}</h4><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database icon-bg"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="card o-hidden">
                        <a href="{{route('customer.show')}}">
                        <div class="bg-secondary b-r-4 card-body">
                            <div class="media static-top-widget">
                                <div class="align-self-center text-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg></div>
                                <div class="media-body"><span class="m-0">Customer</span>
                                    <h4 class="mb-0 counter">{{$client}}</h4><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag icon-bg"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="card o-hidden">
                        <a href="{{route('product.show')}}">
                        <div class="bg-primary b-r-4 card-body">
                            <div class="media static-top-widget">
                                <div class="align-self-center text-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg></div>
                                <div class="media-body"><span class="m-0">Products</span>
                                    <h4 class="mb-0 counter">{{$product}}</h4><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle icon-bg"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3 col-lg-6">
                    <div class="card o-hidden">
                        <a href="{{route('category.show')}}">
                        <div class="bg-primary b-r-4 card-body">
                            <div class="media static-top-widget">
                                <div class="align-self-center text-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg></div>
                                <div class="media-body"><span class="m-0">Category</span>
                                    <h4 class="mb-0 counter">{{$category}}</h4><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus icon-bg"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <!-- Container-fluid Ends-->
    </div>
@endsection
