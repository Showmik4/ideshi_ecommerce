<!-- latest jquery-->
<script src="{{url('public/assets/js/jquery-3.5.1.min.js')}}"></script>

<!-- Bootstrap js-->
<script src="{{url('public/assets/js/bootstrap/bootstrap.bundle.min.js')}}"></script>

<!-- feather icon js-->
<script src="{{url('public/assets/js/icons/feather-icon/feather.min.js')}}"></script>
<script src="{{url('public/assets/js/icons/feather-icon/feather-icon.js')}}"></script>

<!-- scrollbar js-->
<script src="{{url('public/assets/js/scrollbar/simplebar.js')}}"></script>
<script src="{{url('public/assets/js/scrollbar/custom.js')}}"></script>

<!-- Sidebar jquery-->
<script src="{{url('public/assets/js/config.js')}}"></script>

<!-- Plugins JS start-->
<script src="{{url('public/assets/js/sidebar-menu.js')}}"></script>
{{--<script src="{{url('public/assets/js/chart/chartist/chartist.js')}}"></script>--}}
{{--<script src="{{url('public/assets/js/chart/chartist/chartist-plugin-tooltip.js')}}"></script>--}}
<script src="{{url('public/assets/js/chart/knob/knob.min.js')}}"></script>
<script src="{{url('public/assets/js/chart/knob/knob-chart.js')}}"></script>
<script src="{{url('public/assets/js/chart/apex-chart/apex-chart.js')}}"></script>
<script src="{{url('public/assets/js/chart/apex-chart/stock-prices.js')}}"></script>
<script src="{{url('public/assets/js/notify/bootstrap-notify.min.js')}}"></script>
{{--<script src="{{url('public/assets/js/dashboard/default.js')}}"></script>--}}
{{--<script src="{{url('public/assets/js/notify/index.js')}}"></script>--}}
<script src="{{url('public/assets/js/datepicker/date-picker/datepicker.js')}}"></script>
<script src="{{url('public/assets/js/datepicker/date-picker/datepicker.en.js')}}"></script>
<script src="{{url('public/assets/js/datepicker/date-picker/datepicker.custom.js')}}"></script>
{{--<script src="{{url('public/assets/js/typeahead/handlebars.js')}}"></script>--}}
{{--<script src="{{url('public/assets/js/typeahead/typeahead.bundle.js')}}"></script>--}}
{{--<script src="{{url('public/assets/js/typeahead/typeahead.custom.js')}}"></script>--}}
{{--<script src="{{url('public/assets/js/typeahead-search/handlebars.js')}}"></script>--}}
{{--<script src="{{url('public/assets/js/typeahead-search/typeahead-custom.js')}}"></script>--}}
<!-- Plugins JS Ends-->

<!-- Theme js-->
<script src="{{url('public/assets/js/script.js')}}"></script>

<!-- CKEDITOR & CKFINDER -->
<script src="https://cdn.ckeditor.com/4.20.0/full/ckeditor.js"></script>

<script>
    CKEDITOR.config.extraAllowedContent = '*(*);*{*}';
</script>

<!-- DataTables js-->
<script src="{{url('public/assets/js/datatable/datatables/datatable.custom.js')}}"></script>
<script src="{{url('public/assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>

<!--toastr start-->
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    @if(session('message'))
    toastr.info('{{ session('message') }}')
    @endif

    @if(session('warning'))
    toastr.warning('{{ session('warning') }}')
    @endif

    @if(session('success'))
    toastr.success('{{ session('success') }}')
    @endif

    @if(session('error'))
    toastr.error('{{ session('error') }}')
    @endif

    //Jquery On ecnyer event bonding
    (function($) {
        $.fn.onEnter = function(func) {
            this.bind('keypress', function(e) {
                if (e.keyCode === 13) func.apply(this, [e]);
            });
            return this;
        };
    })(jQuery);
</script>
<!--toastr end-->

@yield('footer.js')
