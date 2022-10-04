<!DOCTYPE html>
<html lang="en">

<head>
    <?php include(APPPATH . "views/layout/html_head.php"); ?>
</head>

<body class="bg-grey">
    <?php include(APPPATH . "views/layout/header.php"); ?>

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
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 row">
                            <div class="profile-avatar">
                                <img src="<?php echo $profile["avatar"]; ?>" />
                            </div>
                            <div class="profile-name">
                                <label><?php echo $profile["name"]; ?></label>
                                <span><?php echo isset($profile["divisi"]) ? $profile["divisi"] : ""; ?></span>
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
                                    <label for="user_username">Login ID</label>
                                    <div class="input-group mb-3">
                                        <input type="user_username" name="user_username" id="user_username" class="form-control" value="<?php echo $profile["username"]; ?>" />
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
                            <a class="btn btn-danger float-right" onclick="stepper.next()">Simpan Perubahan</a>
                            <a class="btn btn-default float-right mr-4" onclick="stepper.next()">Ubah Password</a>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </div>
    </div>

    <?php include(APPPATH . "views/layout/footer_script.php"); ?>
</body>

</html>