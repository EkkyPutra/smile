<!DOCTYPE html>
<html lang="en">

<head>
    <?php include(APPPATH . "views/layout/html_head.php"); ?>
</head>

<body>
    <div class="overlay-loading" style="display: none">
        <div class="overlay-loading-spinner">
            <i class="fa fa-spinner fa-spin animated" style="font-size: 38px; margin: 12px;"></i>
            <p>Processing...</p>
        </div>
    </div>
    <div class="content">
        <div class="login-page">
            <div class="login-body row">
                <div class="col-sm-6 login-body-frame"></div>
                <div class="col-sm-6 login-body-form">
                    <h1>Login</h1>
                    <h4>Selamat datang di aplikasi Telkomsel Project Monitoring</h4>
                    <form name="login-form" id="login-form" novalidate="novalidate">
                        <div class="form-group">
                            <label for="username_login">Login ID</label>
                            <div class="input-group mb-3">
                                <input type="text" name="username_login" id="username_login" class="form-control" value="" placeholder="Masukkan Login ID" autocomplete="off" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-group mb-3">
                                <input type="password" name="password_login" id="password_login" class="form-control" value="" placeholder="Masukkan Password" autocomplete="off" />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-eye-slash"></span>
                                        <span class="fas fa-eye"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-danger col-12" id="submit_login" disabled="disabled">Login</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <?php include(APPPATH . "views/layout/footer_script.php"); ?>
    <script src="<?php echo base_url("assets/plugins/jquery-validation/jquery.validate.min.js"); ?>"></script>
    <script type="text/javascript">
        $(".fa-eye-slash").click(
            function() {
                $(".fa-eye").show();
                $(".fa-eye-slash").hide();
                $("#password_login").prop("type", "text");
            }
        );
        $(".fa-eye").click(
            function() {
                $(".fa-eye").hide();
                $(".fa-eye-slash").show();
                $("#password_login").prop("type", "password");
            }
        );
        $("#username_login").keyup(function() {
            var password_login = $("#password_login").val();
            var username_login = $("#username_login").val();

            if (username_login != "" && password_login != "") {
                $("#submit_login").removeAttr("disabled");
            }
        });

        $("#password_login").keyup(function() {
            var password_login = $("#password_login").val();
            var username_login = $("#username_login").val();

            if (username_login != "" && password_login != "") {
                $("#submit_login").removeAttr("disabled");
            }
        });

        $(function() {
            $.validator.setDefaults({
                ignore: ":hidden, [contenteditable='true']:not([name])",
                submitHandler: function(form) {
                    $('.overlay-loading').show();
                    $.ajax({
                        url: '<?php echo base_url("users/dologin"); ?>',
                        type: "POST",
                        data: $("#login-form").serializeArray(),
                        dataType: "JSON",
                        success: function(response) {
                            console.log(response);
                            if (response.result == 200) {
                                $('.overlay-loading').hide();
                                window.location.href = "<?php echo base_url("main"); ?>";
                            } else {
                                $('.overlay-loading').hide();
                                show_notif("error", response.message)
                            }
                        },
                        error: function(error) {
                            $('.overlay-loading').hide();
                            show_notif("error", "Gagal login! Ulangi beberapa saat lagi")
                        }
                    });
                }
            });
            $('#login-form').validate({
                rules: {
                    username_login: {
                        required: true
                    },
                    password_login: {
                        required: true
                    }
                },
                messages: {
                    username_login: {
                        required: "Silahkan masukkan Login ID"
                    },
                    password_login: {
                        required: "Silahkan masukkan Password"
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
</body>

</html>