    <div class="scrool">
        <i class="fas fa-chevron-up"></i>
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url("assets/plugins/jquery/jquery.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/jquery-ui/jquery-ui.min.js"); ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url("assets/plugins/bootstrap/js/bootstrap.bundle.min.js"); ?>"></script>
    <!-- Toastr -->
    <script src="<?php echo base_url("assets/plugins/toastr/toastr.min.js"); ?>"></script>

    <!-- AdminLTE App -->
    <script src="<?php echo base_url("assets/dist/js/adminlte.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/bootstrap-notify.min.js"); ?>" type="text/javascript"></script>

    <script>
        function show_notif(type, message) {
            toastr.options.timeOut = 3000;
            toastr.options.progressBar = true;
            if (type == "success") {
                toastr.success(message)
            } else if (type == "error") {
                toastr.error(message)
            } else if (type == "info") {
                toastr.info(message)
            }
        }

        $(".scrool").on("click", function() {
            $("html, body").animate({
                scrollTop: 0
            }, "slow");
        })
    </script>