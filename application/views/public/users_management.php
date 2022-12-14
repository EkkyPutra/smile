<!DOCTYPE html>
<html lang="en">

<head>
    <?php include(APPPATH . "views/layout/html_head.php"); ?>
    <!-- Bootstrap Table -->
    <link href="<?php echo base_url("assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css"); ?>" rel="stylesheet">
    <!-- Tags Input -->
    <link rel="stylesheet" href="<?php echo base_url("assets/plugins/jquery-ui/jquery-ui.min.css"); ?>" type="text/css">
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
            <div class="card card-default">
                <!-- .card-header -->
                <div class="card-header no-sub">
                    <div class="seg-tools" onclick="window.location.href='<?php echo base_url(); ?>'">
                        <i class="fas fa-arrow-left"></i>
                    </div>
                    <h3 class="seg-title">User Management</h3>
                </div>
                <!-- /.card-header -->
                <!-- .card-body -->
                <div class="card-body">
                    <div class="toolHead row">
                        <h3 class="col-6 seg-title">Daftar User</h3>
                        <div class="col-6 float-right text-right">
                            <button class="btn btn-export"><i class="fas fa-upload"></i> <span>Export File</span></button>
                            <button class="btn btn-tambah" data-toggle="modal" data-target="#modal-lg"><i class="fas fa-plus"></i><span>Tambah User</span></button>
                        </div>
                    </div>
                    <div id="toolbar">
                        <input type="hidden" id="totalPage" name="totalPage" value="<?php echo $totalPage; ?>" />
                        <div class="toolbar-select">
                            <span><i class="far fa-eye"></i> Show</span>
                            <select id="pageLength" class="form-control">
                                <option value="10">10 Rows</option>
                                <option value="25">25 Rows</option>
                                <option value="50">50 Rows</option>
                                <option value="100">100 Rows</option>
                            </select>
                        </div>
                        <div class="toolbar-select row">
                            <span><i class="fas fa-filter"></i> Filters</span>
                            <select id='user_role' class="form-control">
                                <option value=''>-- Role --</option>
                                <?php
                                foreach ($usersRole as $role) {
                                    echo "<option value='" . strtolower($role->value) . "'>" . $role->value . "</option>";
                                }
                                ?>
                            </select>
                            <span id="resetFilter"><i class="fas fa-undo"></i> Reset Filter</span>
                        </div>
                        <div class="toolbar-search float-right">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" name="search" id="searchList" class="form-control" autocomplete="off" placeholder="Search Lists">
                            </div>
                        </div>
                    </div>
                    <?php if ($isMobile) { ?>
                        <table id="tableUsersLists" class="table table-borderless"></table>
                    <?php } else { ?>
                        <table id="tableUsersLists" class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Nama Lengkap</th>
                                    <th>Role</th>
                                    <th>Divisi</th>
                                    <th>Handphone</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    <?php } ?>
                    <div class="pageInfo row">
                        <div class="bInfo col-6 float-left">Showing <span id="infoX">00</span>-<span id="infoY">00</span> of <span id="infoZ">00</span></div>
                        <div class="bPagination col-6 float-right text-right">
                            <ul class="ulBPagination">
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-lg">
        <form name="usersForm" id="usersForm" enctype="multipart/form-data" novalidate="novalidate">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="title-modal-form">Tambah User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row">
                        <div class="col-sm-6 col-12">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="user_name">Nama Lengkap</label>
                                    <div class="input-group">
                                        <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Contoh: John Doe" autocomplete="off" required="required" />
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="user_divisi">Divisi</label>
                                    <div class="input-group">
                                        <select name="user_divisi" id="user_divisi" class="form-control select2" autocomplete="off" required="required">
                                            <option value="">-- Pilih Divisi --</option>
                                            <?php
                                            if (!is_null($usersDivisi)) {
                                                foreach ($usersDivisi as $divisi) {
                                                    echo '<option value="' . $divisi->id . '">' . $divisi->value . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <?php if (!$isMobile) { ?>
                                    <div class="form-group col-12">
                                        <div class="btn-group">
                                            <input type="file" name="user_avatar" id="user_avatar" class="form-control fileinput avatar" required="required" onchange="loadFile(event)" />
                                            <div id="avatar-empty">
                                                <span class="col fileinput-button" id="btn-avatar">
                                                    <i class="fas fa-camera-retro"></i>
                                                    <span>Ambil Gambar</span>
                                                </span>
                                            </div>
                                            <div id="avatar-not-empty">
                                                <div id="user-avatar-overlay"></div>
                                                <img id="user-avatar" src="" />
                                                <span id="btn-avatar-edit">
                                                    <i class="far fa-edit"></i>
                                                    <span id="avatar-edit">Ganti Gambar</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div class="row">
                                <div class="form-group col-sm-6 col-12">
                                    <label for="username">Login ID</label>
                                    <div class="input-group">
                                        <input type="hidden" name="old_username" id="old_username" value="" />
                                        <input type="text" name="username" id="username" class="form-control" placeholder="Contoh: johndoe" autocomplete="off" required="required" />
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 col-12">
                                    <label for="user_role">Role</label>
                                    <div class="input-group">
                                        <select name="user_role" id="user_role" class="form-control" required="required">
                                            <option value="">-- Pilih Role --</option>
                                            <?php
                                            if (!is_null($usersRole)) {
                                                foreach ($usersRole as $role) {
                                                    echo '<option value="' . $role->id . '">' . $role->value . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="handphone">Nomor Telepon</label>
                                    <div class="input-group">
                                        <input type="text" name="handphone" id="handphone" class="form-control" placeholder="Contoh: 0811111999999" autocomplete="off" required="required" />
                                    </div>
                                </div>
                                <?php if ($isMobile) { ?>
                                    <div class="form-group col-12">
                                        <div class="btn-group">
                                            <input type="file" name="user_avatar" id="user_avatar" class="form-control fileinput avatar" required="required" onchange="loadFile(event)" />
                                            <div id="avatar-empty">
                                                <span class="col fileinput-button" id="btn-avatar">
                                                    <i class="fas fa-camera-retro"></i>
                                                    <span>Ambil Gambar</span>
                                                </span>
                                            </div>
                                            <div id="avatar-not-empty">
                                                <div id="user-avatar-overlay"></div>
                                                <img id="user-avatar" src="" />
                                                <span id="btn-avatar-edit">
                                                    <i class="far fa-edit"></i>
                                                    <span id="avatar-edit">Ganti Gambar</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <div class="button-seg">
                            <input type="hidden" name="todo" id="todo" value="" />
                            <button type="button" class="btn btn-default" id="modal-close" data-dismiss="modal">Batal</button>
                            <button type="submit" name="btnTodo" class="btn btn-danger" id="btnForm">Simpan</button>
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
    <!-- Bootstrap Table -->
    <script src="<?php echo base_url("assets/plugins/datatables/jquery.dataTables.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/datatables-buttons/js/buttons.print.min.js"); ?>"></script>
    <!-- BootBox -->
    <script src="<?php echo base_url("assets/js/bootstarp-bootbox.min.js"); ?>"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url("assets/plugins/select2/js/select2.full.min.js"); ?>"></script>
    <!-- bs-custom-file-input -->
    <script src="<?php echo base_url("assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/jquery-validation/jquery.validate.min.js"); ?>"></script>
    <script>
        var $userTable = $('#tableUsersLists');
        var isMobile = "<?php echo $isMobile; ?>";

        var tableColumns;
        if (isMobile == 1) {
            tableColumns = [{
                data: "data",
                width: "100%"
            }];
        } else {
            tableColumns = [{
                    data: "id",
                    width: "5%",
                    orderable: false,
                    className: "align-middle"
                },
                {
                    data: "avatar_thumb",
                    width: "10%",
                    orderable: false
                },
                {
                    data: "name",
                    width: "25%",
                    className: "pt-4"
                },
                {
                    data: "user_role",
                    width: "15%",
                    className: "pt-4"
                },
                {
                    data: "user_divisi",
                    width: "15%",
                    className: "pt-4"
                },
                {
                    data: "handphone",
                    width: "20%",
                    className: "pt-4"
                },
                {
                    data: "action",
                    width: "10%",
                    className: "pt-4"
                }
            ]
        }

        function fetchTable(user_role, page, limit, refresh = false, params = []) {
            var limit = $('#pageLength').find(":selected").val();
            var start = (page == 0) ? ($(".paginationX.pCurrent").attr("data-start")) : page;
            var infoX = ((parseInt(start) - 1) * limit) + 1;
            var infoY = parseInt(start) * limit;
            var currPage = $(".paginationX.pCurrent").attr("data-page");

            $("#infoX").text(infoX);
            $.ajax({
                url: "<?php echo base_url("users/getData"); ?>",
                type: "POST",
                data: {
                    user_role: user_role,
                    params: params,
                    start: start,
                    limit: limit
                },
                dataType: "json",
                success: function(res) {
                    var i = 1;
                    var totalPage = res.recordsTotal;
                    var totalRows = res.totalRows;
                    var rowPage = res.recordsFiltered;
                    $("#infoZ").text(totalRows);

                    if (rowPage != limit) {
                        $("#infoY").text(totalRows);
                    } else {
                        $("#infoY").text(infoY);
                    }
                    $("#totalPage").val(totalPage);

                    if (refresh) {
                        generatePagination(page);
                    }

                    $("#tableUsersLists").DataTable({
                        processing: true,
                        data: res.data,
                        columns: tableColumns,
                        bPaginate: false,
                        bInfo: false,
                        searching: false
                    });
                }
            });
        }
        // fetchTable($("#user_role").val(), 1, $("#pageLength").find(":selected").val());

        $("#user_role").on("change", function(e) {
            e.preventDefault();
            $(".card-body").focusin();

            var user_role = $("#user_role").val();
            $('#tableUsersLists').DataTable().destroy();
            fetchTable(user_role);
        });

        $("#pageLength").on("change", function(e) {
            e.preventDefault();

            var limit = $(this).val();
            var user_role = $("#user_role").val();
            $("#pageLength option").removeAttr("selected");
            $("#pageLength").find("option[value='" + limit + "']").attr("selected", true);
            $('#tableUsersLists').DataTable().destroy();
            fetchTable(user_role, 1, limit, true);
        })

        function generatePagination(currPage = undefined) {
            var limit = $('#pageLength').find(":selected").val();
            var totalPage = $('#totalPage').val();

            $(".ulBPagination").empty();

            var xT = 0;
            var pCurrent = "";
            var minPage = (totalPage >= 4) ? (totalPage - 3) : totalPage;
            var xPage = (currPage === undefined || totalPage <= 4) ? 1 : ((currPage > minPage) ? minPage : currPage);

            for (var i = 1; i <= parseInt(totalPage); i++) {
                if (i == parseInt(currPage)) {
                    pCurrent = "pCurrent";
                } else {
                    pCurrent = "";
                }

                if (i == currPage || (i >= (currPage - 2) && i <= currPage) || (i <= (currPage + 2) && i >= currPage) || i == (currPage + 1) || i == (currPage + 2)) {
                    $(".ulBPagination").append('<li class="paginationX ' + pCurrent + '" data-page="' + i + '" data-start="' + (i - 1) + '">' + i + '</li>');
                }
            }

            var bFirstDisabled = "";
            var bNextDisabled = "";
            var bPrevDisabled = "";
            var bLastDisabled = "";
            if (currPage === undefined || currPage == 1) {
                bFirstDisabled = 'bDisabled';
                bPrevDisabled = 'bDisabled';
            }
            if (currPage === undefined || currPage == totalPage) {
                bLastDisabled = 'bDisabled';
                bNextDisabled = 'bDisabled';
            }

            $(".ulBPagination").append(
                '<li id="bPaginationNav">' +
                '   <span class="btnPagination ' + bFirstDisabled + '" id="bPaginationFirst"><i class="fas fa-angle-double-left"></i></span>' +
                '   <span class="btnPagination ' + bPrevDisabled + '" id="bPaginationPrev"><i class="fas fa-angle-left"></i></span>' +
                '   <span class="btnPagination ' + bNextDisabled + '" id="bPaginationNext"><i class="fas fa-angle-right"></i></span>' +
                '   <span class="btnPagination ' + bLastDisabled + '" id="bPaginationLast"><i class="fas fa-angle-double-right"></i></span>' +
                '</li>');
        }

        $(document).ready(function() {
            fetchTable($("#user_role").val(), 1, $("#pageLength").find(":selected").val(), true);
            // generatePagination(1);
        })

        $(document).on("click", ".paginationX", function() {
            var currPage = $(".paginationX.pCurrent").attr("data-page");
            var clickPage = $(this).attr("data-page");
            var limit = $("#pageLength").find(":selected").val();
            var user_role = $("#user_role").val();

            if (!$(this).hasClass("pCurrent")) {
                $(".overlay-loading").show();
                if (currPage != clickPage) {
                    $('#tableUsersLists').DataTable().destroy();
                    fetchTable(user_role, clickPage, limit, true);
                    setTimeout(function() {
                        $(".overlay-loading").hide();
                    }, 200);
                }
            }
        })

        $(document).on("click", "#bPaginationFirst", function() {
            var currPage = $(".paginationX.pCurrent").attr("data-page");
            var clickPage = parseInt(currPage) - 1;
            var limit = $("#pageLength").find(":selected").val();
            var user_divisi = $("#user_divisi").val();

            if (!$(this).hasClass("bDisabled")) {
                $(".overlay-loading").show();
                if (currPage != clickPage && $("#bPaginationPrev").attr("class") !== "bDisabled") {
                    $('#tableUsersLists').DataTable().destroy();
                    fetchTable(user_divisi, 1, limit, true);
                    setTimeout(function() {
                        $(".overlay-loading").hide();
                    }, 200);
                }
            }
        });

        $(document).on("click", "#bPaginationLast", function() {
            var currPage = $(".paginationX.pCurrent").attr("data-page");
            var clickPage = parseInt(currPage) - 1;
            var limit = $("#pageLength").find(":selected").val();
            var user_divisi = $("#user_divisi").val();
            var totalPage = $('#totalPage').val();

            if (!$(this).hasClass("bDisabled")) {
                $(".overlay-loading").show();
                if (currPage != clickPage && $("#bPaginationPrev").attr("class") !== "bDisabled") {
                    $('#tableUsersLists').DataTable().destroy();
                    fetchTable(user_divisi, totalPage, limit, true);
                    setTimeout(function() {
                        $(".overlay-loading").hide();
                    }, 200);
                }
            }
        });

        $(document).on("click", "#bPaginationPrev", function() {
            var currPage = $(".paginationX.pCurrent").attr("data-page");
            var clickPage = parseInt(currPage) - 1;
            var limit = $("#pageLength").find(":selected").val();
            var user_role = $("#user_role").val();

            if (!$(this).hasClass("bDisabled")) {
                $(".overlay-loading").show();
                if (currPage != clickPage && $("#bPaginationPrev").attr("class") !== "bDisabled") {
                    $('#tableUsersLists').DataTable().destroy();
                    fetchTable(user_role, clickPage, limit, true);
                    setTimeout(function() {
                        $(".overlay-loading").hide();
                    }, 200);
                }
            }
        });

        $(document).on("click", "#bPaginationNext", function() {
            var currPage = $(".paginationX.pCurrent").attr("data-page");
            var clickPage = parseInt(currPage) + 1;
            var limit = $("#pageLength").find(":selected").val();
            var user_role = $("#user_role").val();

            if (!$(this).hasClass("bDisabled")) {
                $(".overlay-loading").show();
                if (currPage != clickPage && $("#bPaginationNext").attr("class") !== "bDisabled") {
                    $('#tableUsersLists').DataTable().destroy();
                    fetchTable(user_role, clickPage, limit, true);
                    setTimeout(function() {
                        $(".overlay-loading").hide();
                    }, 200);
                }
            }
        });

        $(document).on("click", "#resetFilter", function() {
            $("#pageLength option").removeAttr("selected");
            $("#pageLength").val($("#pageLength option:first").val());
            $("#pageLength").find("option[value='" + $("#pageLength option:first").val() + "']").attr("selected", true);
            $("#user_role option").removeAttr("selected");
            $("#user_role").val($("#user_role option:first").val());
            $("#user_role").find("option[value='" + $("#user_role option:first").val() + "']").attr("selected", true);
            $('#tableUsersLists').DataTable().destroy();
            fetchTable("", 1, 1, true);
        })

        $("#btn-avatar").on("click", function() {
            $("#user_avatar").click();
        });
        $("#btn-avatar-edit").on("click", function() {
            $("#user_avatar").click();
        });

        var loadFile = function(event) {
            var output = document.getElementById('user-avatar');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
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

        $("#modal-lg").on("hidden.bs.modal", function(e) {
            $("#usersForm").trigger("reset");
            $("#todo").val("");
        });

        function editUser(username) {
            $("#title-modal-form").html("Edit User");
            $("#usersForm").each(function() {
                elements = $(this).find(':input');
                elements.each(function(key, element) {
                    if ($(element).attr("class") !== "undefined") {
                        $("#" + $(element).attr("id") + "-error").hide();
                        $(element).removeClass("is-invalid")
                    }
                });
            });
            $('.overlay-loading').show();

            $.ajax({
                url: "<?php echo base_url("users/getDetail/") ?>" + username,
                dataType: "JSON",
                type: "GET",
                success: function(response) {
                    if (response.result == 200) {
                        data = response.data.item;
                        $("#user_name").val(data.name);
                        $("#username").val(data.username);
                        $("#old_username").val(data.username);
                        $('select[name^="user_role"] option:selected').removeAttr("selected");
                        $('select[name^="user_role"] option[value=' + data.role + ']').attr("selected", "selected");
                        $('select[name^="user_divisi"] option:selected').removeAttr("selected");
                        $('select[name^="user_divisi"] option[value=' + data.divisi + ']').attr("selected", "selected");

                        $("#handphone").val(data.handphone);
                        $("#avatar-empty").hide();
                        $("#avatar-not-empty").show();
                        $("#user-avatar").attr("src", data.avatar);

                        $("#todo").val("update");
                        $("#user_modal").show();
                        $('.overlay-loading').hide();
                    } else {
                        $('.overlay-loading').hide();
                        show_notif('error', response.message);
                    }
                }
            });
        }

        function removeUser(username) {
            bootbox.confirm({
                title: "Hapus User",
                message: "Apakah kamu yakin untuk menghapus user ini? Aksi ini tidak bisa di kembalikan",
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> Batal'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> Setuju'
                    }
                },
                callback: function(result) {
                    if (result) {
                        $('.overlay-loading').show();
                        $.ajax({
                            url: '<?php echo base_url("users/doRemove"); ?>',
                            type: "post",
                            dataType: "json",
                            data: {
                                username: username
                            },
                            success: function(response) {
                                $('.overlay-loading').hide();
                                if (response.result == 200) {
                                    $("#tableUsersLists").DataTable().destroy();
                                    fetchTable($("#user_role").val(), 1, $("#pageLength").find(":selected").val(), true);
                                    show_notif('success', response.data.name);
                                }
                            }
                        });
                    } else {
                        show_notif('info', 'User batal dihapus');
                    }
                }
            });
        }

        $("#searchList").keypress(function(e) {
            var key = e.which;
            if (key == 13) // the enter key code
            {
                var query = $(this).val();
                var limit = $('#pageLength').find(":selected").val();
                var start = ($(".paginationX.pCurrent").attr("data-start"));
                var params = {
                    query: query
                };

                $.ajax({
                    url: "<?php echo base_url("users/getData"); ?>",
                    type: "POST",
                    data: {
                        params: params,
                        start: start,
                        limit: limit
                    },
                    dataType: "json",
                    success: function(res) {
                        var user_role = $("#user_role").val();
                        $('#tableUsersLists').DataTable().destroy();
                        fetchTable(user_role, 1, limit, true, params);
                    }
                });
            }
        })

        $(".btn-export").on("click", function() {
            $('.overlay-loading').show();
            $.ajax({
                url: '<?php echo base_url("main/exports/users"); ?>',
                type: "post",
                dataType: "json",
                success: function(response) {
                    $('.overlay-loading').hide();
                    if (response.result == 200) {
                        window.open(response.data.item, '_blank');
                    } else {
                        show_notif("error", response.message)
                    }
                },
                error: function(error) {
                    $('.overlay-loading').hide();
                    show_notif("error", "Gagal login! Ulangi beberapa saat lagi")
                }
            })
        })
    </script>
</body>

</html>