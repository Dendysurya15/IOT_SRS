<footer class="main-footer">
    <strong>Copyright © 2022 <a href="https://srs-ssms.com">SRS-SSMS.COM</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.0.5
    </div>
</footer>

<script src="{{ asset('/js/js_tabel/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('/js/js_tabel/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/js/js_tabel/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('/js/js_tabel/buttons.flash.min.js') }}"></script>
<script src="{{ asset('/js/js_tabel/jszip.min.js') }}"></script>
<script src="{{ asset('/js/js_tabel/pdfmake.min.js') }}"></script>
<script src="{{ asset('/js/js_tabel/vfs_fonts.js') }}"></script>
<script src="{{ asset('/js/js_tabel/buttons.html5.min.js') }}"></script>
<script src="{{ asset('/js/js_tabel/buttons.print.min.js') }}"></script>

<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

<script>
    $(function () {
        $('.select2').select2({
            theme: 'bootstrap4'
        });
     })
     
</script>