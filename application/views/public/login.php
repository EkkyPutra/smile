<!DOCTYPE html>
<html lang="en">

<head>
    <?php include(APPPATH . "views/layout/html_head.php"); ?>
    <?php include(APPPATH . "views/layout/body_script.php"); ?>
    <script type="text/javascript">
        $(document).ready(function() {
            var em = $("#email_login").val();
            $("#email_login").prop("autocomplete", "off");
        });
    </script>
</head>

<body>
    <div class="content">
        <div class="login-page">
            <div class="login-body row">
                <div class="col-6 login-body-left"></div>
                <div class="col-6 login-body-right">
                    <h1>Login</h1>
                    <h4>Selamat datang di aplikasi Telkomsel Project Monitoring</h4>
                    <form id="login-form" method="post" action="">
                        <div class="form-group">
                            <label for="email">E-Mail</label>
                            <div class="input-group mb-3">
                                <input type="email" name="email_login" id="email_login" class="form-control" value="" placeholder="Masukkan Email" autocomplete="off" />
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
                            <button type="submit" class="btn btn-danger col-12" disabled="disabled">Login</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            var em = $("#email_login").val();
            $("form").attr("autocomplete", "off");
            console.log($("#email_login").val());
            console.log($("#email_login").attr("value"));
            console.log(em);
        });

        $(".fa-eye-slash").click(
            function() {
                $(".fa-eye").show();
                $(".fa-eye-slash").hide();
                $("#password").prop("type", "text");
            }
        );
        $(".fa-eye").click(
            function() {
                $(".fa-eye").hide();
                $(".fa-eye-slash").show();
                $("#password").prop("type", "password");
            }
        );

        $("#login-form").submit(function(e) {
            alert("asdasda");
        });
    </script>
</body>

</html>