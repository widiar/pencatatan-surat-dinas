<script src="{{ asset('js/vendor/jquery-2.2.4.min.js') }}"></script>
    <!-- bootstrap 4 js -->
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('js/metisMenu.min.js') }}"></script>
<script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('js/jquery.slicknav.min.js') }}"></script>

<!-- Start datatable js -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/responsive.bootstrap4.min.js') }}"></script>

<script src="{{ asset('plugins/datepicker/js/bootstrap-datepicker.min.js') }}"></script>

@yield('script')

<script src="{{ asset('js/scripts.js') }}"></script>
<script src="{{ asset('js/plugins.js') }}"></script>

<script>
    $('#adminTable').DataTable()
    $(".alert").fadeTo(2000, 500).slideUp(500, function(){
        $(".alert").slideUp(500);
    });
    $('.date').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        autoclose: true,
    })
</script>