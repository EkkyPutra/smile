<!DOCTYPE html>
<html lang="en">

<head>
    <?php include(APPPATH . "views/layout/html_head.php"); ?>
    <!-- Bootstrap Table -->
    <link href="<?php echo base_url("assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css"); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url("assets/plugins/jquery-ui/jquery-ui.min.css"); ?>" type="text/css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php echo base_url("assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css"); ?>">
    <!-- Tags Input -->
    <link rel="stylesheet" href="<?php echo base_url("assets/plugins/jquery-ui/jquery-ui.min.css"); ?>" type="text/css">
    <!-- Date Range Picker -->
    <link rel="stylesheet" href="<?php echo base_url("assets/plugins/daterangepicker/daterangepicker.css"); ?>" type="text/css">
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
            <div class="card card-default" id="project-activity">
                <!-- .card-header -->
                <div class="card-header no-sub">
                    <div class="seg-tools" onclick="window.location.href='<?php echo base_url(); ?>'">
                        <i class="fas fa-arrow-left"></i>
                    </div>
                    <div class="row">
                        <h3 class="col-sm-6 col-8 seg-title"><?php echo ($is_performa) ? "Daftar Project PIC" : "Daftar Proyek"; ?></h3>
                        <?php if (!$is_performa) { ?>
                            <div class="toolHead col-sm-6 col-4 float-right text-right mb-1">
                                <button class="btn btn-export"><i class="fas fa-upload"></i> <span>Export File</span></button>
                                <?php
                                $access_level = $user_access["access_level"];
                                if ($access_level->project->is_super == 1 || ($access_level->project->as_divisi == 1 && $access_level->project->access->add == 1))
                                    echo '<button class="btn btn-tambah" data-toggle="modal" data-target="#modal-proyek"><i class="fas fa-plus"></i><span>Tambah Proyek</span></button>';
                                ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- .card-body -->
                <div class="card-body">
                    <div id="toolbar">
                        <?php if ($is_performa) { ?>
                            <div class="general-info" id="general-info">
                                <div class="general-info-seg row">
                                    <div class="gis-left col-sm-6 col-12">
                                        <label class="title">General Information</label>
                                        <div class="form-group mb-0 row">
                                            <label class="col-4 col-form-label">Nama PIC</label>
                                            <label class="col-8 col-form-label">:&nbsp;<?php echo $memberDetail->name; ?></label>
                                        </div>
                                        <div class="form-group mb-0 row">
                                            <label class="col-4 col-form-label">Divisi</label>
                                            <label class="col-8 col-form-label">:&nbsp;<?php echo $memberDetail->user_divisi; ?></label>
                                        </div>
                                        <div class="form-group mb-0 row">
                                            <label class="col-4 col-form-label">Total Proyek</label>
                                            <label class="col-8 col-form-label">:&nbsp;<?php echo $memberDetail->totalProject; ?></label>
                                        </div>
                                        <div class="form-group mb-0 row">
                                            <label class="col-4 col-form-label">Total BAU</label>
                                            <label class="col-8 col-form-label">:&nbsp;<?php echo $memberDetail->totalProjectBau; ?></label>
                                        </div>
                                    </div>
                                    <div class="gis-right col-sm-6 col-12">
                                        <label class="title">Summary Proyek</label>
                                        <div class="form-group mb-0 row">
                                            <label class="col-4 col-form-label">On Track</label>
                                            <label class="col-8 col-form-label"><?php echo $memberDetail->projectOnTrack; ?></label>
                                        </div>
                                        <div class="form-group mb-0 row">
                                            <label class="col-4 col-form-label">Terlambat</label>
                                            <label class="col-8 col-form-label"><?php echo $memberDetail->projectLate; ?></label>
                                        </div>
                                        <div class="form-group mb-0 row">
                                            <label class="col-4 col-form-label">Selesai</label>
                                            <label class="col-8 col-form-label"><?php echo $memberDetail->projectComplete; ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="toolHead row">
                                <h3 class="col-6 seg-title">Proyek PIC</h3>
                                <div class="col-6 float-right text-right">
                                    <button class="btn btn-export"><i class="fas fa-upload"></i> <span>Export File</span></button>
                                    <?php
                                    $access_level = $user_access["access_level"];
                                    if ($access_level->project->is_super == 1 || ($access_level->project->as_divisi == 1 && $access_level->project->access->add == 1))
                                        echo '<button class="btn btn-tambah" data-toggle="modal" data-target="#modal-proyek"><i class="fas fa-plus"></i><span>Tambah Proyek</span></button>';
                                    ?>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if (!$is_performa) { ?>
                            <div class="toolbar-card row" id="toolbar-card">
                                <div class="toolbar-card-item col-6 col-md-3">
                                    <div class="tci tci-blue row">
                                        <span class="col-3"><i class="fas fa-hourglass-half"></i></span>
                                        <div class="tci-info col-12 col-md-9">
                                            <span>Proyek On Track</span>
                                            <h1><?php echo $projectCount->onTrack; ?></h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="toolbar-card-item col-6 col-md-3">
                                    <div class="tci tci-red row">
                                        <span class="col-3"><i class="fas fa-calendar-times"></i></span>
                                        <div class="tci-info col-12 col-md-9">
                                            <span>Proyek Terlambat</span>
                                            <h1><?php echo $projectCount->late; ?></h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="toolbar-card-item col-6 col-md-3">
                                    <div class="tci tci-green row">
                                        <span class="col-3"><i class="fas fa-calendar-check"></i></span>
                                        <div class="tci-info col-12 col-md-9">
                                            <span>Proyek Selesai</span>
                                            <h1><?php echo $projectCount->complete; ?></h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="toolbar-card-item col-6 col-md-3">
                                    <div class="tci tci-orange row">
                                        <span class="col-3"><i class="fas fa-signal"></i></span>
                                        <div class="tci-info col-12 col-md-9">
                                            <span>Total Proyek</span>
                                            <h1><?php echo $projectCount->total; ?></h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="general-info" id="general-info" style="display: none;">
                            <div id="general-info-overlay">
                                <div class="overlay-loading-spinner">
                                    <i class="fa fa-spinner fa-spin animated" style="font-size: 38px; margin: 12px;"></i>
                                </div>
                            </div>
                            <div class="general-info-seg row">
                                <div class="gis-left col-6">
                                    <label class="title">General Information</label>
                                    <div class="form-group mb-0 row">
                                        <label for="inputEmail3" class="col-4 col-form-label">Nama Proyek</label>
                                        <div class="col-8">:&nbsp;
                                            <label id="label-project-name"></label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0 row">
                                        <label for="inputEmail3" class="col-4 col-form-label">Deskripsi Proyek</label>
                                        <div class="col-8">:&nbsp;
                                            <label id="label-project-desc"></label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0 row">
                                        <label for="inputEmail3" class="col-4 col-form-label">Tipe</label>
                                        <div class="col-8">:&nbsp;
                                            <label id="label-project-tipe"><span class='top-priority'><i class='fas fa-angle-double-up'></i> TOP</span></label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0 row">
                                        <label for="inputEmail3" class="col-4 col-form-label">Progress</label>
                                        <div class="col-8 pt-10">:&nbsp;
                                            <div class="progress">
                                                <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" style="width: 45%;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45%</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0 row">
                                        <label for="inputEmail3" class="col-4 col-form-label">Batas Waktu</label>
                                        <div class="col-8">:&nbsp;
                                            <label id="label-project-deadline"></label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0 row">
                                        <label for="inputEmail3" class="col-4 col-form-label">Link Proyek</label>
                                        <div class="col-8">:&nbsp;
                                            <label id="label-project-link"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="gis-right col-6">
                                    <label class="title">PIC Information</label>
                                    <div class="gis-pic">
                                        <label>PIC Leader</label>
                                        <div class="gis-pic-leader row">
                                        </div>
                                        <label>PIC Member</label>
                                        <div class="gis-pic-members">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                        <?php if ($isMobile) { ?>
                            <div class="toolbar-select">
                                <span><i class="fas fa-filter"></i> Filters</span>
                                <select name="filterParams[]" id="projectType" class="form-control select-filter">
                                    <option value=''>Tipe</option>
                                    <?php
                                    foreach ($projectType as $type) {
                                        echo "<option value='" . strtolower($type->value) . "'>" . $type->value . "</option>";
                                    }
                                    ?>
                                </select>
                                <select name="filterParams[]" id="projectPriority" class="form-control select-filter">
                                    <option value=''>Priority</option>
                                    <option value="top">Top</option>
                                    <option value="nontop">Non Top</option>
                                    ?>
                                </select>
                            </div>
                            <div class="toolbar-select">
                                <input type="text" name="filterParams[]" id="filterDeadline" class="form-control filterDeadline" placeholder="-- Batas Waktu --">
                                <select id="user_divisi" class="form-control select-filter">
                                    <option value=''>Divisi</option>
                                    <?php
                                    foreach ($usersDivisi as $divisi) {
                                        echo "<option value='" . strtolower($divisi->value) . "'>" . $divisi->value . "</option>";
                                    }
                                    ?>
                                </select>
                                <select id="filterProjectrogress" class="form-control select-filter">
                                    <option value=''>Progress</option>
                                    <option value="76-100">76% - 100%</option>
                                    <option value="51-75">51% - 75%</option>
                                    <option value="26-50">26% - 50%</option>
                                    <option value="0-25">0% - 25%</option>
                                </select>
                            </div>
                            <div class="toolbar-select">
                                <span id="resetFilter"><i class="fas fa-undo"></i> Reset Filter</span>
                            </div>
                        <?php } else { ?>
                            <div class="toolbar-select">
                                <span><i class="fas fa-filter"></i> Filters</span>
                                <select name="filterParams[]" id="projectType" class="form-control select-filter">
                                    <option value=''>Tipe</option>
                                    <?php
                                    foreach ($projectType as $type) {
                                        echo "<option value='" . strtolower($type->value) . "'>" . $type->value . "</option>";
                                    }
                                    ?>
                                </select>
                                <select name="filterParams[]" id="projectPriority" class="form-control select-filter">
                                    <option value=''>Priority</option>
                                    <option value="top">Top</option>
                                    <option value="nontop">Non Top</option>
                                    ?>
                                </select>
                                <input type="text" name="filterParams[]" id="filterDeadline" class="form-control filterDeadline" placeholder="-- Batas Waktu --">
                                <select id="user_divisi" class="form-control select-filter">
                                    <option value=''>Divisi</option>
                                    <?php
                                    foreach ($usersDivisi as $divisi) {
                                        echo "<option value='" . strtolower($divisi->value) . "'>" . $divisi->value . "</option>";
                                    }
                                    ?>
                                </select>
                                <select id="filterProjectrogress" class="form-control select-filter">
                                    <option value=''>Progress</option>
                                    <option value="ontrack">On Track</option>
                                    <option value="late">Terlambat</option>
                                </select>
                                <span id="resetFilter"><i class="fas fa-undo"></i> Reset Filter</span>
                            </div>
                        <?php } ?>
                        <div class="toolbar-search float-right">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" name="search" id="searchList" class="form-control" autocomplete="off" placeholder="Search Lists">
                            </div>
                        </div>
                        <div class="toolbar-legend">
                            <label><span class="legend-ontrack"></span>On Track</label>
                            <label><span class="legend-late"></span>Terlambat</label>
                        </div>
                    </div>
                    <?php if ($this->agent->is_mobile()) { ?>
                        <table id="tableProjectsLists" class="table table-borderless"></table>
                    <?php } else { ?>
                        <table id="tableProjectsLists" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Proyek</th>
                                    <th>Divisi</th>
                                    <th>Priority</th>
                                    <th>Tipe</th>
                                    <th>Batas Waktu</th>
                                    <th>Progress</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    <?php } ?>
                    <div class="pageInfo row">
                        <?php if ($this->agent->is_mobile()) { ?>
                            <div class="bInfo col-sm-6 col-3 float-left">Showing<br /><span id="infoX">00</span>-<span id="infoY">00</span> of <span id="infoZ">00</span></div>
                        <?php } else { ?>
                            <div class="bInfo col-sm-6 col-3 float-left">Showing <span id="infoX">00</span>-<span id="infoY">00</span> of <span id="infoZ">00</span></div>
                        <?php } ?>
                        <div class="bPagination col-sm-6 col-9 float-right text-right">
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
        <form name="projectForm" id="projectForm" enctype="multipart/form-data" novalidate="novalidate">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="title-modal-form">Tambah Proyek</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row">
                        <input type="hidden" name="project_id" id="project_id" value="" />
                        <label class="modal-seg col-12">Informasi Proyek</label>
                        <div class="col-12 col-sm-6">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="project_name">Nama Proyek</label>
                                    <div class="input-group">
                                        <input type="text" name="project_name" id="project_name" class="form-control" placeholder="Contoh: Proyek website SMILE" autocomplete="off" required="required" />
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="project_link">Link Proyek</label>
                                    <div class="input-group">
                                        <input type="text" name="project_link" id="project_link" class="form-control" placeholder="Contoh: http://www.telkomsel.com" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="project_progress">Progress</label>
                                    <div class="input-group">
                                        <input type="number" name="project_progress" id="project_progress" min="0" max="100" class="form-control form-no-line" placeholder="0" autocomplete="off" required="required" />
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span>%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="project_deadline">Due Date</label>
                                    <div class="input-group">
                                        <input type="text" name="project_deadline" id="project_deadline" class="form-control datetimepicker-input" data-toggle="datetimepicker" placeholder="0" autocomplete="off" required="required" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="project_type">Tipe</label>
                                    <div class="input-group">
                                        <select name="project_type" id="project_type" class="form-control" required="required">
                                            <option value="">-- Pilih Tipe --</option>
                                            <?php
                                            if (!is_null($projectType)) {
                                                foreach ($projectType as $pType) {
                                                    echo '<option value="' . $pType->id . '">' . $pType->value . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="project_priority">Pengaturan Prioritas</label>
                                    <div class="input-group">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="project_priority" name="project_priority">
                                            <label for="project_priority">Atur sebagai TOP</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="project_divisi">Divisi</label>
                                    <div class="input-group">
                                        <select name="project_divisi" id="project_divisi" class="form-control" required="required">
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
                                <div class="form-group col-12">
                                    <label for="project_description">Deskripsi Proyek</label>
                                    <textarea name="project_description" id="project_description" class="form-control" placeholder="Contoh: Proyek prioritas tahun ini" rows="6"></textarea>
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
                        <div class="col-12 row row-pic">
                            <div class="col-12 col-sm-6">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="pic_leader_name">Nama PIC Leader</label>
                                        <input type="text" name="pic_leader_name" id="pic_leader_name" class="form-control" placeholder="Contoh: Dwi Setiawan" autocomplete="off" required="required" />
                                        <input type="hidden" name="pic_leader_id" id="pic_leader_id" />
                                        <div id="autocomplete-pic-leader">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="pic_leader_handphone">Nomor Telepon PIC Leader</label>
                                        <input type="text" name="pic_leader_handphone" id="pic_leader_handphone" class="form-control" placeholder="Contoh: 089818181818" autocomplete="off" required="required" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 row-pic row-pic-member">
                            <input type="hidden" name="count-pic" id="count-pic" value="0" />
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
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?php echo base_url("assets/plugins/moment/moment.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/moment/moment-with-locales.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"); ?>"></script>
    <!-- bs-custom-file-input -->
    <script src="<?php echo base_url("assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/jquery-validation/jquery.validate.min.js"); ?>"></script>
    <!-- Daterangepicker -->
    <script src="<?php echo base_url("assets/plugins/daterangepicker/daterangepicker.js"); ?>"></script>
    <script>
        var $projectTable = $('#tableProjectsLists');

        function fetchTable(user_divisi, page, limit, refresh = false, params = []) {
            var limit = $('#pageLength').find(":selected").val();
            var start = (page == 0) ? ($(".paginationX.pCurrent").attr("data-start")) : page;
            var infoX = ((parseInt(start) - 1) * limit) + 1;
            var infoY = parseInt(start) * limit;
            var currPage = $(".paginationX.pCurrent").attr("data-page");
            var username = "<?php echo (isset($memberDetail) && !is_null($memberDetail) && isset($memberDetail->username)) ? $memberDetail->username : ""; ?>";

            $("#infoX").text(infoX);
            $.ajax({
                url: "<?php echo base_url("projects/getData"); ?>",
                type: "POST",
                data: {
                    params: params,
                    username: username,
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

                    if (res.isMobile) {
                        var tableColumns = [{
                                data: "id",
                                visible: false
                            },
                            {
                                data: "data",
                                width: "100%"
                            }
                        ];
                    } else {
                        var tableColumns = [{
                                data: "id",
                                width: "3%",
                                orderable: false,
                                className: "pt-3 pb-3 align-middle text-center"
                            },
                            {
                                data: "name",
                                width: "19%",
                                className: "pl-0 pr-0 pt-3 pb-3 align-middle"
                            },
                            {
                                data: "project_divisi",
                                width: "12%",
                                className: "pl-2 pr-2 pt-3 pb-3 align-middle text-center"
                            },
                            {
                                data: "priority",
                                width: "7%",
                                className: "pl-2 pr-2 pt-3 pb-3 align-middle text-center"
                            },
                            {
                                data: "project_type",
                                width: "8%",
                                className: "pl-2 pr-2 pt-3 pb-3 text-center align-middle"
                            },
                            {
                                data: "deadline",
                                width: "11%",
                                className: "pl-2 pr-2 pt-3 pb-3 text-center align-middle"
                            },
                            {
                                data: "progress",
                                width: "3%",
                                className: "pl-2 pr-2 pt-3 pb-3 text-center align-middle"
                            },
                            {
                                data: "activity",
                                width: "16%",
                                className: "pl-2 pr-2 pt-3 pb-3 align-middle"
                            },
                            {
                                data: "action",
                                width: "21%",
                                orderable: false,
                                className: "pl-1 pr-0 pt-3 align-middle text-center"
                            }
                        ];
                    }

                    $("#tableProjectsLists").DataTable({
                        processing: true,
                        data: res.data,
                        "createdRow": function(row, data, dataIndex) {
                            console.log(data);
                            if (data.strips == 'strips-ontrack') {
                                $(row).addClass('strips-ontrack');
                            } else if (data.strips == "strips-late") {
                                $(row).addClass('strips-late');
                            }
                        },
                        columns: tableColumns,
                        paging: false,
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
            fetchTable("", 1, $("#pageLength").find(":selected").val(), true);
        })

        $("#pageLength").on("change", function(e) {
            e.preventDefault();

            var limit = $(this).val();
            var user_divisi = $("#user_divisi").val();
            $(".overlay-loading").show();
            $("#pageLength option").removeAttr("selected");
            $("#pageLength").find("option[value='" + limit + "']").attr("selected", true);
            $('#tableProjectsLists').DataTable().destroy();
            fetchTable(user_divisi, 1, limit, true);
            setTimeout(function() {
                $(".overlay-loading").hide();
            }, 200);
        })

        $(".select-filter").on("change", function(e) {
            var selected = $(".select-filter option:selected").map(function() {
                return this.value
            }).get();

            var params = {
                type: selected[0],
                priority: selected[1],
                divisi: selected[2],
                progress: selected[3],
                query: $("#searchList").val(),
                deadline: $("#filterDeadline").val()
            }
            var filterDeadline = $("#filterDeadline").attr("data-onchange-date");

            var query = $(this).val();
            var limit = $('#pageLength').find(":selected").val();
            var start = ($(".paginationX.pCurrent").attr("data-start"));

            $('#tableProjectsLists').DataTable().destroy();
            fetchTable("", 1, limit, true, params);
        });

        $(document).on("click", "#resetFilter", function() {
            $("#pageLength option").removeAttr("selected");
            $("#pageLength").val($("#pageLength option:first").val());
            $("#pageLength").find("option[value='" + $("#pageLength option:first").val() + "']").attr("selected", true);

            $("#filterDeadline").val("");
            $("#projectType option").removeAttr("selected");
            $("#projectType").val($("#projectType option:first").val());
            $("#projectType").find("option[value='" + $("#projectType option:first").val() + "']").attr("selected", true);

            $("#projectPriority option").removeAttr("selected");
            $("#projectPriority").val($("#projectPriority option:first").val());
            $("#projectPriority").find("option[value='" + $("#projectPriority option:first").val() + "']").attr("selected", true);

            $("#user_divisi option").removeAttr("selected");
            $("#user_divisi").val($("#user_divisi option:first").val());
            $("#user_divisi").find("option[value='" + $("#user_divisi option:first").val() + "']").attr("selected", true);

            $("#filterProjectrogress option").removeAttr("selected");
            $("#filterProjectrogress").val($("#filterProjectrogress option:first").val());
            $("#filterProjectrogress").find("option[value='" + $("#filterProjectrogress option:first").val() + "']").attr("selected", true);

            $('#tableProjectsLists').DataTable().destroy();
            fetchTable("", 1, 1, true);
        })

        $(document).on("click", ".paginationX", function() {
            var currPage = $(".paginationX.pCurrent").attr("data-page");
            var clickPage = $(this).attr("data-page");
            var limit = $("#pageLength").find(":selected").val();
            var user_divisi = $("#user_divisi").val();

            if (!$(this).hasClass("pCurrent")) {
                $(".overlay-loading").show();
                if (currPage != clickPage) {
                    $('#tableProjectsLists').DataTable().destroy();
                    fetchTable(user_divisi, clickPage, limit, true);
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
                    $('#tableProjectsLists').DataTable().destroy();
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
                    $('#tableProjectsLists').DataTable().destroy();
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
            var user_divisi = $("#user_divisi").val();

            if (!$(this).hasClass("bDisabled")) {
                $(".overlay-loading").show();
                if (currPage != clickPage && $("#bPaginationPrev").attr("class") !== "bDisabled") {
                    $('#tableProjectsLists').DataTable().destroy();
                    fetchTable(user_divisi, clickPage, limit, true);
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
            var user_divisi = $("#user_divisi").val();

            if (!$(this).hasClass("bDisabled")) {
                $(".overlay-loading").show();
                if (currPage != clickPage && $("#bPaginationNext").attr("class") !== "bDisabled") {
                    $('#tableProjectsLists').DataTable().destroy();
                    fetchTable(user_divisi, clickPage, limit, true);
                    setTimeout(function() {
                        $(".overlay-loading").hide();
                    }, 200);
                }
            }
        });

        $("#filterDeadline").on("focus", function() {
            $("#filterDeadline").attr("data-onchange-date", "false");
            $(this).daterangepicker({
                locale: 'id',
                format: 'DD-MM-YYYY'
            }, function(start, end) {
                var selected = $(".select-filter option:selected").map(function() {
                    return this.value
                }).get();

                var params = {
                    type: selected[0],
                    priority: selected[1],
                    divisi: selected[2],
                    progress: selected[3],
                    query: $("#searchList").val(),
                    deadline: start.format("MM/DD/YYYY") + ' - ' + end.format("MM/DD/YYYY")
                }

                var limit = $('#pageLength').find(":selected").val();
                var start = ($(".paginationX.pCurrent").attr("data-start"));

                $('#tableProjectsLists').DataTable().destroy();
                fetchTable("", 1, limit, true, params);
            });
        })

        $(function() {
            //Date picker
            $('#project_deadline').datetimepicker({
                locale: 'id',
                format: 'DD-MM-YYYY',
                minDate: new Date()
            });

            var projects = "<?php echo base_url("users/listsAjax"); ?>";
            $('#pic_leader_name').autocomplete({
                minLength: 0,
                appendTo: "#autocomplete-pic-leader",
                classes: {
                    "ui-autocomplete": "highlight"
                },
                source: projects,
                focus: function(event, ui) {
                    $("#pic_leader_name").val(ui.item.name);
                    $("#pic_leader_handphone").val(ui.item.handphone);
                    return false;
                },
                select: function(event, ui) {
                    $("#pic_leader_name").val(ui.item.name);
                    $("#pic_leader_handphone").val(ui.item.handphone);
                    $("#pic_leader_id").val(ui.item.id);
                    return false;
                }
            }).data("ui-autocomplete")._renderItem = function(ul, item) {
                return $("<li>")
                    .append("<a>" + item.name + "</a>")
                    .appendTo(ul);
            };
        });

        $("#modal-proyek").on("hidden.bs.modal", function(e) {
            $("#projectForm").trigger("reset");
            $("#todo").val("");
        });

        $(function() {
            $.validator.setDefaults({
                ignore: ":hidden, [contenteditable='true']:not([name])",
                submitHandler: function(form) {
                    $('.overlay-loading').show();
                    todo = $("#todo").val();
                    if (todo == "update") {
                        urlAjax = "<?php echo base_url("projects/doUpdate") ?>";
                    } else {
                        urlAjax = "<?php echo base_url("projects/doCreate") ?>";
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
                                show_notif('success', response.data.name);
                                $("#tableProjectsLists").DataTable().destroy();
                                fetchTable($("#user_divisi").val(), 1, $("#pageLength").find(":selected").val(), true);
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
            $('#projectForm').validate({
                messages: {
                    project_name: {
                        required: "Silahkan masukkan nama proyek"
                    },
                    project_deadline: {
                        required: "Silahkan masukkan due date proyek"
                    },
                    project_divisi: {
                        required: "Silahkan pilih divisi proyek"
                    },
                    project_type: {
                        required: "Silahkan pilih tipe proyek"
                    },
                    project_progress: {
                        required: "Silahkan masukkan progress proyek"
                    },
                    pic_leader_name: {
                        required: "Silahkan pilih PIC Leader Name"
                    },
                    pic_leader_handphone: {
                        required: "Silahkan masukkan PIC Leader Handphone"
                    },
                    project_link: {
                        url: "Silahkan masukkan URL yang valid. Cth : http://www.telkomsel.com"
                    }
                },
                rules: {
                    project_link: {
                        url: true
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

        function editProject(slug) {
            $("#title-modal-form").html("Edit Proyek");
            $("#projectForm").each(function() {
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
                url: "<?php echo base_url("projects/getDetail/") ?>",
                dataType: "JSON",
                data: {
                    slug: slug
                },
                type: "POST",
                success: function(response) {
                    if (response.result == 200) {
                        data = response.data.item;
                        $("#project_id").val(data.id);
                        $("#project_name").val(data.name);
                        $("#project_link").val(data.link);
                        $("#project_progress").val(parseInt(data.progress));
                        $("#project_progress").attr("disabled", "disabled");
                        $("#project_deadline").val(data.deadline);
                        $('select[name^="project_type"] option:selected').removeAttr("selected");
                        $('select[name^="project_type"] option[value=' + data.type + ']').attr("selected", "selected");
                        $('select[name^="project_divisi"] option:selected').removeAttr("selected");
                        $('select[name^="project_divisi"] option[value=' + data.divisi + ']').attr("selected", "selected");

                        $("#project_description").html(data.description);

                        if (data.pic.leader !== undefined) {
                            $("#pic_leader_id").val(data.pic.leader[0].pic_id);
                            $("#pic_leader_name").val(data.pic.leader[0].pic_name);
                            $("#pic_leader_handphone").val(data.pic.leader[0].pic_handphone);
                        }

                        $("#project_priority").removeAttr("checked");
                        if (data.priority == 1) {
                            $("#project_priority").attr("checked", "checked");
                        }

                        $(".row-pic-member").html('<input type="hidden" name="count-pic" id="count-pic" value="0" />');
                        if (data.pic.members !== undefined) {
                            var picX = data.pic.members.length;
                            $("#count-pic").val(picX);
                            $(this.target).find('input').autocomplete();
                            $.each(data.pic.members, function(index, value) {
                                $(".row-pic-member").append('' +
                                    '<div class="col-12 row row-pic" id="row-pic-' + picX + '">' +
                                    '    <div class="col-12 row">' +
                                    '        <label class="modal-seg-pic col-6">PIC Member</label>' +
                                    '        <label class="delete-pic col-6 align-right" data-pic-number="' + picX + '" onclick="removePicRow(\'' + picX + '\');">Delete</label>' +
                                    '    </div>' +
                                    '    <div class="col-12 col-sm-6">' +
                                    '        <div class="row">' +
                                    '            <div class="form-group col-12">' +
                                    '                <label for="pic_leader_name">Nama PIC</label>' +
                                    '                <input type="text" name="pic_member_name[]" id="pic_member_name_' + picX + '" value="' + value.pic_name + '" class="pic_member_name form-control" placeholder="Contoh: Dwi Setiawan" autocomplete="off" required="required" />' +
                                    '                <input type="hidden" name="pic_member_id[]" id="pic_member_id_' + picX + '" value="' + value.pic_id + '" />' +
                                    '                <div id="autocomplete-pic-leader">' +
                                    '                </div>' +
                                    '            </div>' +
                                    '        </div>' +
                                    '    </div>' +
                                    '    <div class="col-12 col-sm-6">' +
                                    '        <div class="row">' +
                                    '            <div class="form-group col-12">' +
                                    '                <label for="pic_leader_handphone">Nomor Telepon PIC</label>' +
                                    '                <input type="text" name="pic_member_handphone[]" id="pic_member_handphone_' + picX + '" value=" ' + value.pic_handphone + '" class="form-control" placeholder="Contoh: 089818181818" autocomplete="off" required="required" />' +
                                    '            </div>' +
                                    '        </div>' +
                                    '    </div>' +
                                    '</div>' +
                                    '');

                                var projects = "<?php echo base_url("users/listsAjax"); ?>";
                                $('#pic_member_name_' + picX).autocomplete({
                                    minLength: 0,
                                    appendTo: "#autocomplete-pic-leader",
                                    classes: {
                                        "ui-autocomplete": "highlight"
                                    },
                                    source: projects,
                                    focus: function(event, ui) {
                                        $("#pic_member_name_" + picX).val(ui.item.name);
                                        $("#pic_member_handphone" + picX).val(ui.item.handphone);
                                        return false;
                                    },
                                    select: function(event, ui) {
                                        $("#pic_member_name_" + picX).val(ui.item.name);
                                        $("#pic_member_handphone_" + picX).val(ui.item.handphone);
                                        $("#pic_member_id_" + picX).val(ui.item.id);
                                        return false;
                                    }
                                }).data("ui-autocomplete")._renderItem = function(ul, item) {
                                    return $("<li>")
                                        .append("<a>" + item.name + "</a>")
                                        .appendTo(ul);
                                };

                            })
                        }
                        $("#todo").val("update");
                        $('.overlay-loading').hide();
                    } else {
                        $('.overlay-loading').hide();
                        show_notif('error', response.message);
                    }
                }
            });
        }

        function removeProject(id) {
            bootbox.confirm({
                title: "Hapus Proyek",
                message: "Apakah kamu yakin untuk menghapus proyek ini? Aksi ini tidak bisa di kembalikan",
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
                            url: '<?php echo base_url("projects/doRemove"); ?>',
                            type: "post",
                            dataType: "json",
                            data: {
                                id: id
                            },
                            success: function(response) {
                                $('.overlay-loading').hide();
                                if (response.result == 200) {
                                    $("#tableProjectsLists").DataTable().destroy();
                                    fetchTable($("#user_divisi").val(), 1, $("#pageLength").find(":selected").val(), true);
                                    show_notif('success', response.data.name);
                                }
                            }
                        });
                    } else {
                        show_notif('info', 'Proyek batal dihapus');
                    }
                }
            });
        }

        $(".add-pic").on("click", function() {
            // $('.pic_member_name').autocomplete("destroy");
            $(this.target).find('input').autocomplete();

            var countPic = $("#count-pic").val();
            var picX = parseInt(countPic) + 1;
            $("#count-pic").val(picX);
            $(".row-pic-member").append('' +
                '<div class="col-12 row row-pic" id="row-pic-' + picX + '">' +
                '    <div class="col-12 row">' +
                '        <label class="modal-seg-pic col-6">PIC Member</label>' +
                '        <label class="delete-pic col-6 align-right" data-pic-number="' + picX + '" onclick="removePicRow(\'' + picX + '\');">Delete</label>' +
                '    </div>' +
                '    <div class="col-12 col-sm-6">' +
                '        <div class="row">' +
                '            <div class="form-group col-12">' +
                '                <label for="pic_leader_name">Nama PIC</label>' +
                '                <input type="text" name="pic_member_name[]" id="pic_member_name_' + picX + '" class="pic_member_name form-control" placeholder="Contoh: Dwi Setiawan" autocomplete="off" required="required" />' +
                '                <input type="hidden" name="pic_member_id[]" id="pic_member_id_' + picX + '" />' +
                '                <div id="autocomplete-pic-leader">' +
                '                </div>' +
                '            </div>' +
                '        </div>' +
                '    </div>' +
                '    <div class="col-12 col-sm-6">' +
                '        <div class="row">' +
                '            <div class="form-group col-12">' +
                '                <label for="pic_leader_handphone">Nomor Telepon PIC</label>' +
                '                <input type="text" name="pic_member_handphone[]" id="pic_member_handphone_' + picX + '" class="form-control" placeholder="Contoh: 089818181818" autocomplete="off" required="required" />' +
                '            </div>' +
                '        </div>' +
                '    </div>' +
                '</div>' +
                '');

            var projects = "<?php echo base_url("users/listsAjax"); ?>";
            $('#pic_member_name_' + picX).autocomplete({
                minLength: 0,
                appendTo: "#autocomplete-pic-leader",
                classes: {
                    "ui-autocomplete": "highlight"
                },
                source: projects,
                focus: function(event, ui) {
                    $("#pic_member_name_" + picX).val(ui.item.name);
                    $("#pic_member_handphone" + picX).val(ui.item.handphone);
                    return false;
                },
                select: function(event, ui) {
                    $("#pic_member_name_" + picX).val(ui.item.name);
                    $("#pic_member_handphone_" + picX).val(ui.item.handphone);
                    $("#pic_member_id_" + picX).val(ui.item.id);
                    return false;
                }
            }).data("ui-autocomplete")._renderItem = function(ul, item) {
                return $("<li>")
                    .append("<a>" + item.name + "</a>")
                    .appendTo(ul);
            };
        })

        function removePicRow(id) {
            var countPic = $("#count-pic").val();
            var picX = parseInt(countPic) - 1;
            $("#count-pic").val(picX);

            $("#row-pic-" + id).remove();
        }

        $("#searchList").keypress(function(e) {
            var key = e.which;
            if (key == 13) // the enter key code
            {
                var query = $(this).val();
                var selected = $(".select-filter option:selected").map(function() {
                    return this.value
                }).get();

                var params = {
                    query: query,
                    type: selected[0],
                    priority: selected[1],
                    divisi: selected[2],
                    progress: selected[3],
                    deadline: $("#filterDeadline").val()
                }

                var limit = $('#pageLength').find(":selected").val();
                var start = ($(".paginationX.pCurrent").attr("data-start"));

                $('#tableProjectsLists').DataTable().destroy();
                fetchTable("", 1, limit, true, params);
            }
        })

        $(".btn-export").on("click", function() {
            $('.overlay-loading').show();
            $.ajax({
                url: '<?php echo base_url("main/exports/projects"); ?>',
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