<!DOCTYPE html>
<html lang="en">

<head>
    <?php include(APPPATH . "views/layout/html_head.php"); ?>
</head>

<body class="bg-grey">
    <?php include(APPPATH . "views/layout/header.php"); ?>
    <div class="overlay-loading" style="display: none">
        <div class="overlay-loading-spinner">
            <i class="fa fa-spinner fa-spin animated" style="font-size: 38px; margin: 12px;"></i>
            <p>Processing...</p>
        </div>
    </div>

    <div class="content">
        <div class="profile-page">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <!-- .card-header -->
                <div class="card-header">
                    <div class="seg-tools" onclick="window.location.href='<?php echo base_url(); ?>'">
                        <i class="fas fa-arrow-left"></i>
                    </div>
                    <h3 class="seg-title">Profil Saya</h3>
                    <h4 class="seg-subtitle">Lihat dan edit profile anda disini</h4>
                </div>
                <!-- /.card-header -->
                <!-- .card-body -->
                <?php
                $avatar = $profile["avatar"];
                $avatarImg = @file_get_contents($avatar);
                if (!empty($profile["avatar"])) {
                    if ($avatarImg) {
                        $imageData = base64_encode($avatarImg);
                    } else {
                        $avatar = IMAGE_DEFAULT_PATH . "no-avatar.png";
                        $imageData = base64_encode(@file_get_contents($avatar));
                    }
                } else {
                    $avatar = IMAGE_DEFAULT_PATH . "no-avatar.png";
                    $imageData = base64_encode(@file_get_contents($avatar));
                }

                ?>
                <div class="card-body">
                    <form name="usersForm" id="usersForm" enctype="multipart/form-data" novalidate="novalidate">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="profile-avatar">
                                        <img src="<?php echo "data: " . mime_content_type($avatar) . ";base64," . $imageData; ?>" />
                                    </div>
                                    <div class="profile-name">
                                        <label><?php echo $profile["name"]; ?></label>
                                        <span><?php echo isset($profile["divisi"]) ? $profile["divisi"] : ""; ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-12">
                                <div class="row">
                                    <div class="form-group col-sm-6 col-12">
                                        <label for="user_name">Nama Lengkap</label>
                                        <div class="input-group mb-3">
                                            <input type="user_name" name="user_name" id="user_name" class="form-control" value="<?php echo $profile["name"]; ?>" />
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-user"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-3 col-12">
                                        <label for="old_username">Login ID</label>
                                        <div class="input-group mb-3">
                                            <input type="old_username" name="old_username" id="old_username" class="form-control" value="<?php echo $profile["username"]; ?>" />
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-unlock"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-3 col-12">
                                        <label for="user_role">Role</label>
                                        <div class="input-group mb-3">
                                            <input type="user_role" name="user_role" id="user_role" class="form-control" disabled="disabled" value="<?php echo $profile["role"]; ?>" />
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-user-shield"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-12 col-12">
                                <div class="row">
                                    <div class="form-group col-sm-6 col-12">
                                        <label for="user_divisi">Divisi</label>
                                        <div class="input-group mb-3">
                                            <input type="user_divisi" name="user_divisi" id="user_divisi" class="form-control" disabled="disabled" value="<?php echo $profile["divisi"]; ?>" />
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-user-tag"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6 col-12">
                                        <label for="user_handphone">Nomor Telepon</label>
                                        <div class="input-group mb-3">
                                            <input type="user_handphone" name="user_handphone" id="user_handphone" class="form-control" value="<?php echo $profile["handphone"]; ?>" />
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-phone-alt"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-12">
                                <button type="submit" name="btnTodo" class="btn btn-danger float-right" id="btnForm">Simpan Perubahan</button>
                                <a class="btn btn-default float-right mr-4" data-toggle="modal" data-target="#modal-profile">Ubah Password</a>
                            </div>
                        </div>
                        <!-- /.row -->
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <div class="modal fade" id="modal-profile">
        <form name="profileForm" id="profileForm" enctype="multipart/form-data" novalidate="novalidate">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Ubah Password<br /><small>Buat password baru untuk akun kamu. Password harus terdiri dari minimal 6 karakter dengan kombinasi huruf dan angka.</small></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row">
                        <input type="hidden" name="profile_username" id="profile_username" value="<?php echo $profile["username"]; ?>" />
                        <div class="col-sm-12 col-12">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="activities_name">Password Lama</label>
                                    <div class="input-group">
                                        <input type="password" name="profile_old_password" id="profile_old_password" class="form-control" placeholder="Masukkan Password Lama" autocomplete="off" required="required" />
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-eye-slash" id="show-old-password"></span>
                                                <span class="fas fa-eye" id="hide-old-password"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="profile_new_password">Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" name="profile_new_password" id="profile_new_password" class="form-control form-no-line" placeholder="Masukkan Password Baru" autocomplete="off" required="required" />
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-eye-slash" id="show-new-password"></span>
                                                <span class="fas fa-eye" id="hide-new-password"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="profile_confirm_new_password">Konfirmasi Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" name="profile_confirm_new_password" id="profile_confirm_new_password" class="form-control" placeholder="Masukkan Konfirmasi Paassword Baru" autocomplete="off" required="required" />
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-eye-slash" id="show-confirm-new-password"></span>
                                                <span class="fas fa-eye" id="hide-confirm-new-password"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <div class="button-seg">
                            <input type="hidden" name="todoProfile" id="todoProfile" value="" />
                            <button type="button" class="btn btn-default" id="modal-close" data-dismiss="modal">Batal</button>
                            <button type="submit" name="" class="btn btn-danger" id="btnChangePassword">Simpan</button>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </form>
    </div>
    <!-- /.modal -->

    <?php include(APPPATH . "views/layout/footer_script.php"); ?>
    <script src="<?php echo base_url("assets/plugins/jquery-validation/jquery.validate.min.js"); ?>"></script>

    <script>
        $("#show-old-password").click(
            function() {
                $("#hide-old-password").show();
                $("#show-old-password").hide();
                $("#profile_old_password").prop("type", "text");
            }
        );
        $("#hide-old-password").click(
            function() {
                $("#hide-old-password").hide();
                $("#show-old-password").show();
                $("#profile_old_password").prop("type", "password");
            }
        );

        $("#show-new-password").click(
            function() {
                $("#hide-new-password").show();
                $("#show-new-password").hide();
                $("#profile_new_password").prop("type", "text");
            }
        );
        $("#hide-new-password").click(
            function() {
                $("#hide-new-password").hide();
                $("#show-new-password").show();
                $("#profile_new_password").prop("type", "password");
            }
        );

        $("#show-confirm-new-password").click(
            function() {
                $("#hide-confirm-new-password").show();
                $("#show-confirm-new-password").hide();
                $("#profile_confirm_new_password").prop("type", "text");
            }
        );
        $("#hide-confirm-new-password").click(
            function() {
                $("#hide-confirm-new-password").hide();
                $("#show-confirm-new-password").show();
                $("#profile_confirm_new_password").prop("type", "password");
            }
        );

        $("#modal-profile").on("hidden.bs.modal", function(e) {
            $("#profileForm").trigger("reset");
            $("#todoProfile").val("");
        });

        $("#modal-profile").on('show.bs.modal', function() {
            $("#todoProfile").val("change-password");
        });

        $(function() {
            $.validator.setDefaults({
                ignore: ":hidden, [contenteditable='true']:not([name])",
                submitHandler: function(form) {
                    $('.overlay-loading').show();
                    todo = $("#todoProfile").val();
                    if (todo == "change-password") {
                        urlAjax = "<?php echo base_url("users/changePassword") ?>";
                    } else {
                        urlAjax = "<?php echo base_url("users/doUpdate") ?>";
                    }

                    $.ajax({
                        url: urlAjax,
                        type: "POST",
                        data: new FormData(form),
                        async: true,
                        dataType: "JSON",
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.result == 200) {
                                $(".overlay-loading").hide();
                                location.reload();
                            } else {
                                $('.overlay-loading').hide();
                                show_notif("error", response.message)
                            }
                        },
                        error: function(error) {
                            $('.overlay-loading').hide();
                            show_notif("error", "Gagal Update Data! Ulangi beberapa saat lagi")
                        }
                    });
                }
            });
            $('#usersForm').validate({
                messages: {
                    user_name: {
                        required: "Silahkan masukkan nama user"
                    },
                    username: {
                        required: "Silahkan masukkan Login ID user"
                    },
                    user_role: {
                        required: "Silahkan pilih role user"
                    },
                    user_divisi: {
                        required: "Silahkan pilih divisi user"
                    },
                    handphone: {
                        required: "Silahkan masukkan nomor telepon"
                    },
                    avatar: {
                        required: "Silahkan masukkan avatar user"
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

            $('#profileForm').validate({
                messages: {
                    profile_old_password: {
                        required: "Silahkan masukkan password lama"
                    },
                    profile_new_password: {
                        required: "Silahkan masukkan password baru",
                        equalTo: "Password baru anda tidak sama."
                    },
                    profile_confirm_new_password: {
                        required: "Silahkan masukkan konfirmasi password baru",
                        equalTo: "Password baru anda tidak sama."
                    }
                },
                rules: {
                    profile_new_password: {
                        equalTo: "#profile_confirm_new_password"
                    },
                    profile_confirm_new_password: {
                        equalTo: "#profile_new_password"
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