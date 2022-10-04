<!DOCTYPE html>
<html lang="en">

<head>
    <?php include(APPPATH . "views/layout/html_head.php"); ?>
    <!-- Bootstrap Table -->
    <link href="<?php echo base_url("assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css"); ?>" rel="stylesheet">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php echo base_url("assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css"); ?>">
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
        <div class="proyek-page">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <!-- .card-header -->
                <div class="card-header no-sub">
                    <div class="seg-tools">
                        <i class="fas fa-arrow-left"></i>
                    </div>
                    <div class="row">
                        <h3 class="col-6 seg-title">Daftar Proyek</h3>
                        <div class="toolHead col-6 float-right text-right mb-1">
                            <button class="btn btn-export"><i class="fas fa-download"></i> Export File</button>
                            <button class="btn btn-tambah" data-toggle="modal" data-target="#modal-proyek">Tambah Proyek</button>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- .card-body -->
                <div class="card-body">
                    <div id="toolbar">
                        <div class="toolbar-card row">
                            <div class="toolbar-card-item col-3">
                                <div class="tci tci-blue row">
                                    <span class="col-4"><i class="fas fa-hourglass-half"></i></span>
                                    <div class="tci-info col-8">
                                        <span>Proyek On Track</span>
                                        <h1>10</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="toolbar-card-item col-3">
                                <div class="tci tci-red row">
                                    <span class="col-4"><i class="fas fa-calendar-times"></i></span>
                                    <div class="tci-info col-8">
                                        <span>Proyek Terlambat</span>
                                        <h1>3</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="toolbar-card-item col-3">
                                <div class="tci tci-green row">
                                    <span class="col-4"><i class="fas fa-calendar-check"></i></span>
                                    <div class="tci-info col-8">
                                        <span>Proyek Selesai</span>
                                        <h1>8</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="toolbar-card-item col-3">
                                <div class="tci tci-orange row">
                                    <span class="col-4"><i class="fas fa-signal"></i></span>
                                    <div class="tci-info col-8">
                                        <span>Total Proyek</span>
                                        <h1>13</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="general-info">
                            <div class="general-info-seg row">
                                <div class="gis-left col-6">
                                    <label class="title">General Information</label>
                                    <div class="form-group mb-0 row">
                                        <label for="inputEmail3" class="col-4 col-form-label">Nama Proyek</label>
                                        <div class="col-8">
                                            <label>: Pengembangan Aplikasi VMS</label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0 row">
                                        <label for="inputEmail3" class="col-4 col-form-label">Deskripsi Proyek</label>
                                        <div class="col-8">
                                            <label>: Pengembangan Aplikasi VMS untuk kebutuhan manajemen kunjungan karyawan telkomsel</label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0 row">
                                        <label for="inputEmail3" class="col-4 col-form-label">Tipe</label>
                                        <div class="col-8">
                                            <label>: <span class='top-priority'><i class='fas fa-angle-double-up'></i> TOP</span></label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0 row">
                                        <label for="inputEmail3" class="col-4 col-form-label">Progress</label>
                                        <div class="col-8 pt-10">:
                                            <div class="progress">
                                                <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" style="width: 45%;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45%</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0 row">
                                        <label for="inputEmail3" class="col-4 col-form-label">Batas Waktu</label>
                                        <div class="col-8">
                                            <label>: 26 Januari 2022</label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0 row">
                                        <label for="inputEmail3" class="col-4 col-form-label">Link Proyek</label>
                                        <div class="col-8">
                                            <label>: <a href="">smile.com/evidence.pdf</a></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="gis-right col-6">
                                    <label class="title">PIC Information</label>
                                    <div class="gis-pic">
                                        <label>PIC Leader</label>
                                        <div class="row">
                                            <div class="gis-init col-1">
                                                <span>YS</span>
                                            </div>
                                            <div class="gis-info col-11">
                                                <label>Yandan Setiawan</label>
                                                <span>+62 82221111908</span>
                                            </div>
                                        </div>
                                        <label>PIC Member</label>
                                        <div class="row">
                                            <div class="gis-init col-1">
                                                <span>YS</span>
                                            </div>
                                            <div class="gis-info col-11">
                                                <label>Yandan Setiawan</label>
                                                <span>+62 82221111908</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="gis-init col-1">
                                                <span>YS</span>
                                            </div>
                                            <div class="gis-info col-11">
                                                <label>Yandan Setiawan</label>
                                                <span>+62 82221111908</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="gis-init col-1">
                                                <span>YS</span>
                                            </div>
                                            <div class="gis-info col-11">
                                                <label>Yandan Setiawan</label>
                                                <span>+62 82221111908</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="gis-init col-1">
                                                <span>YS</span>
                                            </div>
                                            <div class="gis-info col-11">
                                                <label>Yandan Setiawan</label>
                                                <span>+62 82221111908</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="gis-init col-1">
                                                <span>YS</span>
                                            </div>
                                            <div class="gis-info col-11">
                                                <label>Yandan Setiawan</label>
                                                <span>+62 82221111908</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <input type="hidden" id="totalPage" name="totalPage" value="<?php echo $totalPage; ?>" /> -->
                        <div class="toolbar-select">
                            <span><i class="far fa-eye"></i> Show</span>
                            <select id="pageLength">
                                <option value="10">10 Rows</option>
                                <option value="25">25 Rows</option>
                                <option value="50">50 Rows</option>
                                <option value="100">100 Rows</option>
                            </select>
                        </div>
                        <!-- <div class="toolbar-select">
                            <span><i class="fas fa-filter"></i> Filters</span>
                            <select id='user_role'>
                                <option value=''>-- Role --</option>
                                <?php
                                foreach ($usersRole as $role) {
                                    echo "<option value='" . strtolower($role->value) . "'>" . $role->value . "</option>";
                                }
                                ?>
                            </select>
                            <span id="resetFilter"><i class="fas fa-undo"></i> Reset</span>
                        </div>
                        <div class="toolbar-search float-right">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" name="search" id="search" class="form-control" placeholder="Search Lists">
                            </div>
                        </div> -->
                    </div>
                    <table id="tableProjectsLists" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Proyek</th>
                                <th>Divisi</th>
                                <th>Priority</th>
                                <th>Tipe</th>
                                <th>Batas Waktu</th>
                                <th>Progress</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
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

    <div class="modal fade modal-overflow" id="modal-proyek">
        <form name="usersForm" id="usersForm" enctype="multipart/form-data" novalidate="novalidate">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Proyek</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row">
                        <label class="modal-seg col-12">Informasi Proyek</label>
                        <div class="col-6">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="proyek_name">Nama Proyek</label>
                                    <div class="input-group">
                                        <input type="text" name="proyek_name" id="proyek_name" class="form-control" placeholder="Contoh: Proyek website SMILE" autocomplete="off" required="required" />
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="user_divisi">Link Proyek</label>
                                    <div class="input-group">
                                        <input type="text" name="proyek_name" id="proyek_name" class="form-control" placeholder="Contoh: http://www.telkomsel.com" autocomplete="off" required="required" />
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="user_divisi">Progress</label>
                                    <div class="input-group">
                                        <input type="text" name="proyek_name" id="proyek_name" class="form-control" placeholder="Contoh: http://www.telkomsel.com" autocomplete="off" required="required" />
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="user_divisi">Due Date</label>
                                    <div class="input-group">
                                        <input type="text" name="proyek_name" id="proyek_name" class="form-control" placeholder="Contoh: http://www.telkomsel.com" autocomplete="off" required="required" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="username">Tipe</label>
                                    <div class="input-group">
                                        <select name="user_role" id="user_role" class="form-control" required="required">
                                            <option value="">-- Pilih Tipe --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="username">Pengaturan Prioritas</label>
                                    <div class="input-group">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="checkboxPrimary1">
                                            <label for="checkboxPrimary1">Atur sebagai TOP</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="user_role">Divisi</label>
                                    <div class="input-group">
                                        <select name="user_role" id="user_role" class="form-control" required="required">
                                            <option value="">-- Pilih Divisi --</option>
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
                                    <label for="handphone">Deskripsi Proyek</label>
                                    <textarea name="handphone" id="handphone" class="form-control" placeholder="Contoh: 0811111999999" rows="6"></textarea>
                                </div>
                            </div>
                        </div>
                        <label class="modal-seg col-12">PIC</label>
                        <div class="col-12">
                            <div class="modal-info">
                                <i class="fas fa-info-circle"></i>
                                <span>Nomor telepon yang diisikan pada kolom ini akan digunakan untuk berkomunikasi via Whatsapp</span>
                            </div>
                        </div>
                        <div class="col-12 row">
                            <div class="col-6">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="proyek_name">Nama Proyek</label>
                                        <div class="input-group">
                                            <input type="text" name="proyek_name" id="proyek_name" class="form-control" placeholder="Contoh: Proyek website SMILE" autocomplete="off" required="required" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="proyek_name">Nomor Telepon PIC Leader</label>
                                        <div class="input-group">
                                            <input type="text" name="proyek_name" id="proyek_name" class="form-control" placeholder="Contoh: Proyek website SMILE" autocomplete="off" required="required" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="add-pic">+ Tambahkan PIC Member</label>
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
    <!-- bs-custom-file-input -->
    <script src="<?php echo base_url("assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/jquery-validation/jquery.validate.min.js"); ?>"></script>
    <script>
        var $projectTable = $('#tableProjectsLists');

        function fetchTable(user_role, page, limit, refresh = false) {
            var limit = $('#pageLength').find(":selected").val();
            var start = (page == 0) ? ($(".paginationX.pCurrent").attr("data-start")) : page;
            var infoX = ((parseInt(start) - 1) * limit) + 1;
            var infoY = parseInt(start) * limit;
            var currPage = $(".paginationX.pCurrent").attr("data-page");

            $("#infoX").text(infoX);
            $.ajax({
                url: "<?php echo base_url("projects/getData"); ?>",
                type: "POST",
                data: {
                    user_role: user_role,
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

                    $("#tableProjectsLists").DataTable({
                        processing: true,
                        data: res.data,
                        "createdRow": function(row, data, dataIndex) {
                            if (data[2] == `someVal`) {
                                $(row).addClass('redClass');
                            }
                        },
                        columns: [{
                                data: "id",
                                width: "3%",
                                orderable: false,
                                className: "pt-4 text-center"
                            },
                            {
                                data: "name",
                                width: "19%",
                                className: "pl-0 pr-0 pt-4"
                            },
                            {
                                data: "project_divisi",
                                width: "12%",
                                className: "pt-3 text-center"
                            },
                            {
                                data: "priority",
                                width: "8%",
                                className: "pl-2 pr-2 pt-4 text-center"
                            },
                            {
                                data: "project_type",
                                width: "8%",
                                className: "pt-4"
                            },
                            {
                                data: "deadline",
                                width: "11%",
                                className: "pt-4"
                            },
                            {
                                data: "progress",
                                width: "19%",
                                className: "pt-4"
                            },
                            {
                                data: "action",
                                width: "20%",
                                className: "pr-0 pt-3"
                            }
                        ],
                        bPaginate: false,
                        bInfo: false,
                        searching: false
                    });
                }
            });
        }

        function generatePagination(currPage = undefined) {
            var limit = $('#pageLength').find(":selected").val();
            var totalPage = $('#totalPage').val();

            $(".ulBPagination").empty();

            var xT = 0;
            var pCurrent = "";
            var minPage = (totalPage >= 4) ? (totalPage - 3) : totalPage;
            var xPage = (currPage === undefined || totalPage <= 4) ? 1 : ((currPage > minPage) ? minPage : currPage);

            for (var i = xPage; i <= parseInt(totalPage); i++) {
                if (i == parseInt(currPage)) {
                    pCurrent = "pCurrent";
                } else {
                    pCurrent = "";
                }

                if ((totalPage > 4 && (i == parseInt(xPage) || i == (parseInt(xPage) + 1))) || (i >= 6 && ((i == (totalPage - 1)) || (i == totalPage)))) {
                    $(".ulBPagination").append('<li class="paginationX ' + pCurrent + '" data-page="' + i + '" data-start="' + (i - 1) + '">' + i + '</li>');
                } else if (totalPage <= 2) {
                    $(".ulBPagination").append('<li class="paginationX ' + pCurrent + '" data-page="' + i + '" data-start="' + (i - 1) + '">' + i + '</li>');
                } else if (totalPage == 3 || totalPage == 4) {
                    $(".ulBPagination").append('<li class="paginationX ' + pCurrent + '" data-page="' + i + '" data-start="' + (i - 1) + '">' + i + '</li>');
                } else {
                    xT = xT + 1;
                    if (xT <= 2) {
                        $(".ulBPagination").append('<li data-page="' + i + '" data-start="' + (i - 1) + '">.</li>');
                    }
                }
            }

            var bPrevDisabled = "";
            var bNextDisabled = "";
            if (currPage === undefined || currPage == 1) {
                bPrevDisabled = 'class="bDisabled"';
            }
            if (currPage === undefined || currPage == totalPage) {
                bNextDisabled = 'class="bDisabled"';
            }

            $(".ulBPagination").append(
                '<li id="bPaginationNav">' +
                '<span id="bPaginationPrev" ' + bPrevDisabled + '><i class=" fas fa-chevron-left"></i></span>' +
                '<span id="bPaginationNext" ' + bNextDisabled + '><i class="fas fa-chevron-right"></i></span > ' +
                '</li>');
        }

        $(document).ready(function() {
            fetchTable($("#user_role").val(), 1, $("#pageLength").find(":selected").val(), true);
            // generatePagination(1);
        })
    </script>

</body>

</html>