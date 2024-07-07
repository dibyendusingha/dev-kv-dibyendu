<footer class="main-footer font-xs">
    <div class="row pb-30 pt-15">
        <div class="col-sm-6">
            <script>
                document.write(new Date().getFullYear());
            </script>
            &copy; Krishi Vikas Udyog .
        </div>
        <div class="col-sm-6">
            <div class="text-sm-end">All rights reserved</div>
        </div>
    </div>
</footer>
</main>
<script src="{{ URL::asset('admin/js/vendors/jquery-3.6.0.min.js') }}"></script>
<script src="{{ URL::asset('admin/js/vendors/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('admin/js/vendors/select2.min.js') }}"></script>
<script src="{{ URL::asset('admin/js/vendors/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('admin/js/vendors/jquery.fullscreen.min.js') }}"></script>
<script src="{{ URL::asset('admin/js/vendors/chart.js') }}"></script>
<!-- Main Script -->
<script src="{{ URL::asset('admin/js/main.js?v=1.1') }}" type="text/javascript"></script>
<script src="{{ URL::asset('admin/js/custom-chart.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('admin/js/datatable/datatable-btns.js?ver=2.9.1') }}" type="text/javascript"></script>

<script>
    $('.edit-btn-sidebar').click(() => {
        $('.edit_modal_sidebar').addClass('active-edit');
        $('.modal_wrapper').addClass('active-wrapper');
    })
    $('.close-edit').click(() => {
        $('.edit_modal_sidebar').removeClass('active-edit');
        $('.modal_wrapper').removeClass('active-wrapper');
    })
</script>
<script>
    function exportToExcel() {
        const table = document.getElementById('table');
        const wb = XLSX.utils.table_to_book(table);
        XLSX.writeFile(wb, 'exported_data.xlsx');
    }

    function exportToExcelOfflineLead() {
        const table = document.getElementById('tableOffline');
        const wb = XLSX.utils.table_to_book(table);
        XLSX.writeFile(wb, 'offline_lead.xlsx');
    }

    function exportToExcelSellerLead() {
        const table = document.getElementById('sellerLead');
        const wb = XLSX.utils.table_to_book(table);
        XLSX.writeFile(wb, 'seller-lead.xlsx');
    }
</script>

</body>

</html>