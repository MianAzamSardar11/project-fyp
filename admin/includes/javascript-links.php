<!--============== js links ==============-->

<script src="assets/js/feather-icons/feather.min.js"></script>
<script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="assets/js/app.js"></script>

<script src="assets/vendors/chartjs/Chart.min.js"></script>
<script src="assets/vendors/apexcharts/apexcharts.min.js"></script>
<script src="assets/js/pages/dashboard.js"></script>
<!-- form editor js -->
<!-- <script src="assets/vendors/quill/quill.min.js"></script>
<script src="assets/js/pages/form-editor.js"></script> -->

<script src="assets/js/main.js"></script>
<!-- datatable js -->
<script src="assets/vendors/simple-datatables/simple-datatables.js"></script>
<script src="assets/js/vendors.js"></script>


<script>
    // Automatically hide alert after 3 seconds
    document.addEventListener("DOMContentLoaded", function() {
        const alert = document.querySelector('.alert');
        if (alert) {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 3000);
        }
    });
</script>