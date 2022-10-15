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
                    <div class="seg-tools">
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
                            <div class="col-6">
                                <div class="row">
                                    <div class="form-group col-12">
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
                                    <div class="form-group col-12">
                                        <label for="user_divisi">Divisi</label>
                                        <div class="input-group mb-3">
                                            <input type="user_divisi" name="user_divisi" id="user_divisi" class="form-control" value="<?php echo $profile["divisi"]; ?>" />
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-user-tag"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-6">
                                <div class="row">
                                    <div class="form-group col-6">
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
                                    <div class="form-group col-6">
                                        <label for="user_role">Role</label>
                                        <div class="input-group mb-3">
                                            <input type="user_role" name="user_role" id="user_role" class="form-control" value="<?php echo $profile["role"]; ?>" />
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-user-shield"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-12">
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
                                <a class="btn btn-default float-right mr-4">Ubah Password</a>
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

    <?php include(APPPATH . "views/layout/footer_script.php"); ?>
    <script src="<?php echo base_url("assets/plugins/jquery-validation/jquery.validate.min.js"); ?>"></script>

    <script>
        $(function() {
            $.validator.setDefaults({
                ignore: ":hidden, [contenteditable='true']:not([name])",
                submitHandler: function(form) {
                    $('.overlay-loading').show();
                    todo = $("#todo").val();
                    if (todo == "update") {
                        urlAjax = "<?php echo base_url("users/doUpdate") ?>";
                    } else {
                        urlAjax = "<?php echo base_url("users/doCreate") ?>";
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
                                $("#modal-close").click();
                                $("#tableUsersLists").DataTable().destroy();
                                fetchTable($("#user_role").val(), 1, $("#pageLength").find(":selected").val(), true);
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
        });
        
    </script>
</body>

</html>