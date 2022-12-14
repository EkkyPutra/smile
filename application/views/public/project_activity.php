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
            <?php if (!is_null($projectDetail)) { ?>
                <!-- SELECT2 EXAMPLE -->
                <div class="card card-default" id="project-activity">
                    <!-- .card-header -->
                    <div class="card-header no-sub">
                        <div class="seg-tools" onClick="location.href='<?php echo base_url("projects/management"); ?>'">
                            <i class="fas fa-arrow-left"></i>
                        </div>
                        <div class="row">
                            <h3 class="col-sm-6 col-12 seg-title"><?php echo $projectDetail->name; ?></h3>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- .card-body -->
                    <div class="card-body">
                        <div id="toolbar">
                            <div class="general-info" id="general-info">
                                <div class="general-info-seg row">
                                    <div class="gis-left col-sm-6 col-12">
                                        <label class="title">General Information</label>
                                        <div class="form-group mb-0 row">
                                            <label class="col-4 col-form-label">Nama Proyek</label>
                                            <label class="col-8 col-form-label">:&nbsp;<?php echo $projectDetail->name; ?></label>
                                        </div>
                                        <div class="form-group mb-0 row">
                                            <label class="col-4 col-form-label">Deskripsi Proyek</label>
                                            <label class="col-8 col-form-label">:&nbsp;<?php echo $projectDetail->description; ?></label>
                                        </div>
                                        <div class="form-group mb-0 row">
                                            <label class="col-4 col-form-label">Tipe</label>
                                            <label class="col-8 col-form-label">:&nbsp;
                                                <span style="margin-right: 10px;"><?php echo strtoupper($projectDetail->project_type); ?></span>
                                                <?php if (intval($projectDetail->priority) == 1) { ?>
                                                    <span class='top-priority'><i class='fas fa-angle-double-up'></i> TOP</span>
                                                <?php } ?>
                                            </label>
                                        </div>
                                        <div class="form-group mb-0 row">
                                            <label class="col-4 col-form-label">Progress</label>
                                            <div class="col-8 pt-10">:&nbsp;
                                                <div class="progress" id="general-info-progress">
                                                    <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" style="width: <?php echo $projectDetail->last_progress; ?>%;" aria-valuenow="<?php echo $projectDetail->last_progress; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $projectDetail->last_progress; ?>%</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0 row">
                                            <label class="col-4 col-form-label">Batas Waktu</label>
                                            <label class="col-8 col-form-label">:&nbsp;<?php echo $projectDetail->deadline; ?></label>
                                        </div>
                                        <div class="form-group mb-0 row">
                                            <label class="col-4 col-form-label">Divisi</label>
                                            <label class="col-8 col-form-label">:&nbsp;<?php echo '<div class="table-seg-box" style="background-color: #' . $projectDetail->project_divisi_bg . '; color: #' . $projectDetail->project_divisi_color . '">' . ucwords($projectDetail->project_divisi) . '</div>'; ?></label>
                                        </div>
                                        <div class="form-group mb-0 row">
                                            <label class="col-4 col-form-label">Link Proyek</label>
                                            <label class="col-8 col-form-label">:&nbsp;<a href="<?php echo $projectDetail->link; ?>" target="_blank"><?php echo $projectDetail->link; ?></a></label>
                                        </div>
                                    </div>
                                    <div class="gis-right col-sm-6 col-12">
                                        <label class="title">PIC Information</label>
                                        <div class="gis-pic">
                                            <?php if (isset($projectPicLeader)) { ?>
                                                <label>PIC Leader</label>
                                                <div class="gis-pic-leader row">
                                                    <div class="gis-init col-sm-1 col-2">
                                                        <span id="label-pic-leader-initial"><?php echo $projectPicLeader->pic_init; ?></span>
                                                    </div>
                                                    <div class="gis-info col-sm-11 col-10">
                                                        <label id="label-pic-leader-name"><?php echo $projectPicLeader->pic_name; ?></label>
                                                        <span id="label-pic-leader-handphone"><?php echo $projectPicLeader->pic_handphone; ?></span>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <label>PIC Member</label>
                                            <div class="gis-pic-members">
                                                <?php
                                                if (isset($projectDetail->pic->members) && !empty($projectDetail->pic->members) && !is_null($projectDetail->pic->members)) {
                                                    foreach ($projectDetail->pic->members as $picMember) {
                                                        $picMemberrInitial = "";
                                                        foreach (explode(" ", $picMember->pic_name, 2) as $memberInit) {
                                                            $picMemberrInitial .= substr($memberInit, 0, 1);
                                                        }

                                                        echo '<div class="row">';
                                                        echo '   <div class="gis-init col-sm-1 col-2">';
                                                        echo '       <span id="label-pic-leader-initial">' . $picMemberrInitial . '</span>';
                                                        echo '   </div>';
                                                        echo '   <div class="gis-info col-sm-11 col-10">';
                                                        echo '       <label id="label-pic-leader-name">' . $picMember->pic_name . '</label>';
                                                        echo '       <span id="label-pic-leader-handphone">' . $picMember->pic_handphone . '</span>';
                                                        echo '   </div>';
                                                        echo '</div>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="toolHead row">
                                <h3 class="col-6 seg-title">Daftar Aktivitas</h3>
                                <div class="col-6 float-right text-right">
                                    <button class="btn btn-export"><i class="fas fa-upload"></i> <span>Export File</span></button>

                                    <?php
                                    $access_level = $user_access["access_level"];
                                    if ($access_level->activity->is_super == 1 || ($access_level->activity->as_divisi == 1 && strtoupper($user_access["divisi"]) == strtoupper($projectDetail->project_divisi)) || $asAssign)
                                        echo '<button class="btn btn-tambah" data-toggle="modal" data-target="#modal-activity"><i class="fas fa-plus"></i><span>Tambah Aktivitas</span></button>';
                                    ?>
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
                                    <input type="text" name="filterParams[]" id="filterLastUpdate" class="form-control filterLastUpdate" placeholder="-- Last Update --">
                                </div>
                                <div class="toolbar-select">
                                    <select id="project_progress" class="form-control select-filter">
                                        <option value=''>Progress</option>
                                        <option value="76-100">76% - 100%</option>
                                        <option value="51-75">51% - 75%</option>
                                        <option value="26-50">26% - 50%</option>
                                        <option value="0-25">0% - 25%</option>
                                        ?>
                                    </select>
                                    <span id="resetFilter"><i class="fas fa-undo"></i> Reset Filter</span>
                                </div>
                            <?php } else { ?>
                                <div class="toolbar-select">
                                    <span><i class="fas fa-filter"></i> Filters</span>
                                    <input type="text" name="filterParams[]" id="filterLastUpdate" class="form-control filterLastUpdate" placeholder="-- Last Update --">
                                    <select id="project_progress" class="form-control select-filter">
                                        <option value=''>Progress</option>
                                        <option value="76-100">76% - 100%</option>
                                        <option value="51-75">51% - 75%</option>
                                        <option value="26-50">26% - 50%</option>
                                        <option value="0-25">0% - 25%</option>
                                        ?>
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
                        </div>
                        <div class="row">
                            <div class="project-activity col-sm-8 col-12">
                                <?php if ($isMobile) { ?>
                                    <table id="tableActivitiesLists" class="table table-borderless"></table>
                                <?php } else { ?>
                                    <table id="tableActivitiesLists" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Aktivitas</th>
                                                <th>Last Update</th>
                                                <th>Aktivitas Progress</th>
                                                <th>Evidence</th>
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
                            <div class="activity-comment col-sm-4 col-12">
                                <div class="comment-box">
                                    <form name="form-comment">
                                        <div class="comment-count">
                                            <i class="fas fa-angle-double-right"></i>
                                            <span>
                                                <?php
                                                if (!is_null($comments->items)) {
                                                    echo $comments->total;
                                                } else {
                                                    echo 0;
                                                }

                                                $access_level = $user_access["access_level"];
                                                $commentDisable = 'disabled="disabled"';
                                                $addCommentClass = "disabled";
                                                $replyDisable = 'disabled="disabled"';
                                                $addReplyClass = "disabled";
                                                if ($access_level->comment->is_super == 1 || ($access_level->comment->as_divisi == 1 && $user_access["divisi"] == $projectDetail->project_divisi) || $access_level->comment->access->add == 1) {
                                                    $commentDisable = '';
                                                    $addCommentClass = '';
                                                }
                                                if ($access_level->comment->is_super == 1 || ($access_level->comment->as_divisi == 1 && $user_access["divisi"] == $projectDetail->project_divisi) || $access_level->comment->access->reply == 1) {
                                                    $replyDisable = '';
                                                    $addReplyClass = '';
                                                }
                                                ?>
                                                &nbsp;Comment
                                            </span>
                                        </div>
                                        <div class="form-group col-12 input-group">
                                            <form name="comment-form" id="comment-form">
                                                <textarea class="form-control" name="comment-text" id="comment-text" rows="3" style="resize: none;" <?php echo $commentDisable; ?>></textarea>
                                                <div class="input-group-append <?php echo $addCommentClass; ?>" id="button-add-comment">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-paper-plane"></i>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="form-group form-comment-seg">
                                            <?php
                                            if (!is_null($comments->items)) {
                                                $countComment = count($comments->items);
                                                $xComment = ($countComment > 5) ? $countComment - 5 : 5;
                                                foreach ($comments->items as $keyComment => $comment) {
                                                    $commentInitial = "";
                                                    foreach (explode(" ", $comment->username, 2) as $commentInit) {
                                                        $commentInitial .= substr($commentInit, 0, 1);
                                                    }

                                                    $hideComment = "";
                                                    if (($keyComment + 1) > 5) {
                                                        $hideComment = 'style="display:none;"';
                                                    }
                                                    echo '<div class="comment-reply row" id="comment-reply-' . $comment->id . '" ' . $hideComment . '>';
                                                    echo '    <div class="comment-reply-init">';
                                                    echo '        <span>' . $commentInitial . '</span>';
                                                    echo '    </div>';
                                                    echo '    <div class="comment-reply-text" id="comment-reply-text-' . $comment->id . '">';
                                                    echo '        <div class="comment-reply-text-box">';
                                                    echo '            <span class="comment-name">' . $comment->username . '</span>';
                                                    echo '            <span class="comment-role">' . $comment->user_role . '&nbsp;' . $comment->user_divisi . '</span>';
                                                    echo '            <p>' . $comment->comment . '</p>';
                                                    echo '        </div>';
                                                    echo '        <div class="comment-reply-info">';
                                                    echo '            <span class="comment-info-date">About ' . $this->myutils->dateDiff(date("Y-m-d H:i:s"), $comment->created, 1) . ' ago |</span>';
                                                    echo '            <span class="comment-info-reply">Reply</span>';
                                                    echo '        </div>';
                                                    echo '        <div class="comment-reply-input input-group">';
                                                    echo '            <input type="text" name="comment-reply-textbox" id="comment-reply-textbox-' . $comment->id . '" class="form-control comment-reply-textbox" data-comment-id="' . $comment->id . '" ' . $replyDisable . ' placeholder="Add Reply" autocomplete="off" required="required" />';
                                                    echo '            <div class="input-group-append button-add-reply ' . $addReplyClass . '" id="button-add-reply-' . $comment->id . '" data-reply-id="' . $comment->id . '" onclick="javascript:addCommentReply(\'' . $comment->id . '\')">';
                                                    echo '                <div class="input-group-text">';
                                                    echo '                    <i class="fas fa-paper-plane"></i>';
                                                    echo '                </div>';
                                                    echo '            </div>';
                                                    echo '        </div>';

                                                    if (!is_null($comment->reply)) {
                                                        $totalReply = 0;
                                                        $countReply = count($comment->reply);

                                                        if ($countReply > 2) {
                                                            echo '<div class="comment-btn-level" data-comment-id="' . $comment->id . '">';
                                                            echo '    <i class="fas fa-level-up-alt"></i>';
                                                            echo '    <span>view replies (' . ($countReply - 2) . ')</span>';
                                                            echo '</div>';
                                                        }

                                                        foreach ($comment->reply as $keyReply => $reply) {
                                                            $replyCss = '';
                                                            if ($countReply > 2) {
                                                                if ($keyReply < ($countReply - 2)) {
                                                                    $replyCss = 'style="display: none;"';
                                                                }
                                                            }

                                                            $replyInitial = "";
                                                            foreach (explode(" ", $reply->username, 2) as $replyInit) {
                                                                $replyInitial .= substr($replyInit, 0, 1);
                                                            }

                                                            echo '<div class="comment-reply row" data-comment-id="' . $comment->id . '" ' . $replyCss . '>';
                                                            echo '    <div class="comment-reply-init">';
                                                            echo '        <span>' . $replyInitial . '</span>';
                                                            echo '    </div>';
                                                            echo '    <div class="comment-reply-text">';
                                                            echo '        <div class="comment-reply-text-box">';
                                                            echo '            <span class="comment-name">' . $reply->username . '</span>';
                                                            echo '            <span class="comment-role">' . $reply->user_divisi . '&nbsp;' . $reply->user_role . '</span>';
                                                            echo '            <p>' . $reply->comment . '</p>';
                                                            echo '        </div>';
                                                            echo '        <div class="comment-reply-info">';
                                                            echo '            <span class="comment-info-date">About ' . $this->myutils->dateDiff(date("Y-m-d H:i:s"), $reply->created, 1) . ' ago |</span>';
                                                            echo '            <span class="comment-info-reply">Reply</span>';
                                                            echo '        </div>';
                                                            echo '    </div>';
                                                            echo '</div>';
                                                        }
                                                    }

                                                    echo '    </div>';
                                                    echo '</div>';
                                                }

                                                if ($countComment > 5) {
                                                    echo '<div class="comment-btn-all">';
                                                    echo '    <span>Load all ' . ($countComment - 5) . ' comments</span>';
                                                    echo '</div>';
                                                }
                                            }

                                            ?>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            <?php } else { ?>
                <?php include(APPPATH . "views/layout/error_page.php"); ?>
            <?php } ?>
        </div>
    </div>

    <div class="modal fade" id="modal-activity">
        <form name="activitiesForm" id="activitiesForm" enctype="multipart/form-data" novalidate="novalidate">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Aktivitas</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row">
                        <input type="hidden" name="activities_project_id" id="activities_project_id" value="<?php echo $projectDetail->id; ?>" />
                        <input type="hidden" name="activities_id" id="activities_id" value="" />
                        <div class="col-sm-12 col-12">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="activities_name">Nama Aktivitas</label>
                                    <div class="input-group">
                                        <input type="text" name="activities_name" id="activities_name" class="form-control" placeholder="Contoh: Design UI/UX Figma" autocomplete="off" required="required" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="activities_progress">Progress</label>
                                    <div class="input-group">
                                        <input type="number" name="activities_progress" id="activities_progress" min="0" max="100" class="form-control form-no-line" placeholder="0" autocomplete="off" required="required" />
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span>%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="activities_evidence">Evidence</label>
                                    <div class="input-group">
                                        <input type="text" name="activities_evidence" id="activities_evidence" class="form-control" placeholder="Contoh: smile.com/evidence.png" autocomplete="off" />
                                    </div>
                                </div>
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
    <script src="<?php echo base_url("assets/plugins/moment/moment.min.js"); ?>"></script>
    <!-- bs-custom-file-input -->
    <script src="<?php echo base_url("assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/plugins/jquery-validation/jquery.validate.min.js"); ?>"></script>
    <!-- Daterangepicker -->
    <script src="<?php echo base_url("assets/plugins/daterangepicker/daterangepicker.js"); ?>"></script>
    <script>
        var $projectTable = $('#tableActivitiesLists');

        function fetchTable(user_role, page, limit, refresh = false, params = []) {
            var limit = $('#pageLength').find(":selected").val();
            var start = (page == 0) ? ($(".paginationX.pCurrent").attr("data-start")) : page;
            var infoX = ((parseInt(start) - 1) * limit) + 1;
            var infoY = parseInt(start) * limit;
            var currPage = $(".paginationX.pCurrent").attr("data-page");

            $("#infoX").text(infoX);
            $.ajax({
                url: "<?php echo base_url("activities/getData"); ?>",
                type: "POST",
                data: {
                    project_id: <?php echo $projectDetail->id; ?>,
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

                    var tableColumnDefs;
                    if (res.isMobile) {
                        var tableColumns = [{
                            data: "id",
                            visible: false
                        }, {
                            data: "data",
                            width: "100%"
                        }];
                    } else {
                        var tableColumns = [{
                                data: "id",
                                width: "5%",
                                orderable: false,
                                className: "text-center align-middle"
                            },
                            {
                                data: "name",
                                width: "20%",
                                className: "pl-0 pr-0 align-middle"
                            },
                            {
                                data: "updated",
                                width: "20%",
                                className: "text-center align-middle"
                            },
                            {
                                data: "progress",
                                width: "25%",
                                className: "pl-2 pr-2 text-center align-middle"
                            },
                            {
                                data: "evidence",
                                width: "15%",
                                orderable: false,
                                className: "text-center align-middle"
                            },
                            {
                                data: "action",
                                width: "15%",
                                orderable: false,
                                className: "pr-0 align-middle text-center"
                            }
                        ];

                        tableColumnDefs = [{
                            className: "dt-head-center",
                            targets: [2, 4, 5]
                        }, {
                            className: "pl-2 pr-2",
                            targets: [2, 4]
                        }];
                    }

                    $("#tableActivitiesLists").DataTable({
                        processing: true,
                        data: res.data,
                        "createdRow": function(row, data, dataIndex) {
                            if (data[2] == `someVal`) {
                                $(row).addClass('redClass');
                            }
                        },
                        columns: tableColumns,
                        columnDefs: tableColumnDefs,
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
        })

        $("#pageLength").on("change", function(e) {
            e.preventDefault();

            var limit = $(this).val();
            var user_role = $("#user_role").val();
            $(".overlay-loading").show();
            $("#pageLength option").removeAttr("selected");
            $("#pageLength").find("option[value='" + limit + "']").attr("selected", true);
            $('#tableActivitiesLists').DataTable().destroy();
            fetchTable(user_role, 1, limit, true);
            setTimeout(function() {
                $(".overlay-loading").hide();
            }, 200);
        })

        $(document).on("click", ".paginationX", function() {
            var currPage = $(".paginationX.pCurrent").attr("data-page");
            var clickPage = $(this).attr("data-page");
            var limit = $("#pageLength").find(":selected").val();
            var user_role = $("#user_role").val();

            if (!$(this).hasClass("pCurrent")) {
                $(".overlay-loading").show();
                if (currPage != clickPage) {
                    $('#tableActivitiesLists').DataTable().destroy();
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
                    $('#tableActivitiesLists').DataTable().destroy();
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
                    $('#tableActivitiesLists').DataTable().destroy();
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
                    $('#tableActivitiesLists').DataTable().destroy();
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
                    $('#tableActivitiesLists').DataTable().destroy();
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

            $("#filterLastUpdate").val("");
            $("#project_progress option").removeAttr("selected");
            $("#project_progress").val($("#project_progress option:first").val());
            $("#project_progress").find("option[value='" + $("#project_progress option:first").val() + "']").attr("selected", true);

            $('#tableActivitiesLists').DataTable().destroy();
            fetchTable("", 1, 1, true);
        });

        $("#modal-activity").on("hidden.bs.modal", function(e) {
            $("#activitiesForm").trigger("reset");
            $("#todo").val("");
        });

        $(function() {
            $.validator.setDefaults({
                ignore: ":hidden, [contenteditable='true']:not([name])",
                submitHandler: function(form) {
                    $('.overlay-loading').show();
                    todo = $("#todo").val();
                    if (todo == "update") {
                        urlAjax = "<?php echo base_url("activities/doUpdate") ?>";
                    } else {
                        urlAjax = "<?php echo base_url("activities/doCreate") ?>";
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

                                $("#general-info-progress").html('<div class="progress-bar bg-primary progress-bar-striped" role="progressbar" style="width: ' + response.data.item.progress + '%;" aria-valuenow="' + response.data.item.progress + '" aria-valuemin="0" aria-valuemax="100">' + response.data.item.progress + '%</div>');

                                $("#tableActivitiesLists").DataTable().destroy();
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
            $('#activitiesForm').validate({
                messages: {
                    activities_name: {
                        required: "Silahkan masukkan nama aktivitas"
                    },
                    activities_progress: {
                        required: "Silahkan masukkan progress aktivitas"
                    },
                    activities_evidence: {
                        required: "Silahkan masukkan evidence aktivitas",
                        url: "Silahkan masukkan URL yang valid. Cth : http://www.telkomsel.com"
                    }
                },
                rules: {
                    activities_evidence: {
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

        $(".select-filter").on("change", function(e) {
            var selected = $(".select-filter option:selected").map(function() {
                return this.value
            }).get();

            var params = {
                progress: selected[0],
                query: $("#searchList").val(),
                lastupdate: $("#filterLastUpdate").val()
            }

            var limit = $('#pageLength').find(":selected").val();
            var start = ($(".paginationX.pCurrent").attr("data-start"));

            $('#tableActivitiesLists').DataTable().destroy();
            fetchTable("", 1, limit, true, params);
        });

        $("#filterLastUpdate").on("focus", function() {
            $(this).daterangepicker({
                locale: 'id',
                format: 'DD-MM-YYYY'
            }, function(start, end) {
                var selected = $(".select-filter option:selected").map(function() {
                    return this.value
                }).get();

                var params = {
                    progress: selected[0],
                    query: $("#searchList").val(),
                    lastupdate: start.format("MM/DD/YYYY") + ' - ' + end.format("MM/DD/YYYY")
                }

                var limit = $('#pageLength').find(":selected").val();
                var start = ($(".paginationX.pCurrent").attr("data-start"));

                $('#tableActivitiesLists').DataTable().destroy();
                fetchTable("", 1, limit, true, params);
            });
        })

        $("#searchList").keypress(function(e) {
            var key = e.which;
            if (key == 13) // the enter key code
            {
                var query = $(this).val();
                var selected = $(".select-filter option:selected").map(function() {
                    return this.value
                }).get();

                var params = {
                    progress: selected[0],
                    query: $("#searchList").val(),
                    lastupdate: $("#filterLastUpdate").val()
                }

                var limit = $('#pageLength').find(":selected").val();
                var start = ($(".paginationX.pCurrent").attr("data-start"));

                $('#tableActivitiesLists').DataTable().destroy();
                fetchTable("", 1, limit, true, params);
            }
        })

        function editActivity(id) {
            $("#activitiesForm").each(function() {
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
                url: "<?php echo base_url("activities/getDetail/") ?>",
                dataType: "JSON",
                type: "POST",
                data: {
                    id: id
                },
                success: function(response) {
                    if (response.result == 200) {
                        data = response.data.item;
                        $("#activities_name").val(data.name);
                        $("#activities_progress").val(data.progress);
                        $("#activities_evidence").val(data.evidence);
                        $("#activities_id").val(data.id);

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

        function removeActivity(id) {
            bootbox.confirm({
                title: "Hapus Proyek",
                message: "Apakah kamu yakin untuk menghapus aktivitas ini? Aksi ini tidak bisa di kembalikan",
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
                            url: '<?php echo base_url("activities/doRemove"); ?>',
                            type: "post",
                            dataType: "json",
                            data: {
                                id: id
                            },
                            success: function(response) {
                                $('.overlay-loading').hide();
                                if (response.result == 200) {
                                    $("#general-info-progress").html('<div class="progress-bar bg-primary progress-bar-striped" role="progressbar" style="width: ' + response.data.item.last_progress + '%;" aria-valuenow="' + response.data.item.last_progress + '" aria-valuemin="0" aria-valuemax="100">' + response.data.item.last_progress + '%</div>');
                                    $("#tableActivitiesLists").DataTable().destroy();
                                    fetchTable($("#user_role").val(), 1, $("#pageLength").find(":selected").val(), true);
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

        $("#button-add-comment").on("click", function() {
            if ($("#comment-text").val() !== "") {
                $('.overlay-loading').show();
                $.ajax({
                    url: '<?php echo base_url("activities/addCommentReply"); ?>',
                    type: "post",
                    dataType: "json",
                    data: {
                        comment: $("#comment-text").val(),
                        project_id: <?php echo $projectDetail->id; ?>
                    },
                    success: function(response) {
                        $('.overlay-loading').hide();
                        if (response.result == 200) {
                            var newComment = response.data.item;
                            $(".form-comment-seg").prepend('' +
                                '<div class="comment-reply row" id="comment-reply-' + newComment.id + '" style="display: none">' +
                                '    <div class="comment-reply-init">' +
                                '        <span>' + newComment.user_initial + '</span>' +
                                '    </div>' +
                                '    <div class="comment-reply-text" id="comment-reply-text-' + newComment.id + '">' +
                                '        <div class="comment-reply-text-box">' +
                                '            <span class="comment-name">' + newComment.user_name + '</span>' +
                                '            <span class="comment-role">' + newComment.user_role + ' ' + newComment.user_divisi + '</span>' +
                                '            <p>' + newComment.comment + '</p>' +
                                '        </div>' +
                                '        <div class="comment-reply-info">' +
                                '            <span class="comment-info-date">About a few seconds ago |</span>' +
                                '            <span class="comment-info-reply">Reply</span>' +
                                '        </div>' +
                                '        <div class="comment-reply-input input-group">' +
                                '            <input type="text" name="comment-reply-textbox" id="comment-reply-textbox-' + newComment.id + '" class="form-control comment-reply-textbox" placeholder="Add Reply" data-comment-id="' + newComment.id + '" placeholder="Add Reply" autocomplete="off" required="required" />' +
                                '            <div class="input-group-append button-add-reply" id="button-add-reply-' + newComment.id + '" data-reply-id="' + newComment.id + '" onclick="javascript:addCommentReply(\'' + newComment.id + '\')">' +
                                '                <div class="input-group-text">' +
                                '                    <i class="fas fa-paper-plane"></i>' +
                                '                </div>' +
                                '            </div>' +
                                '        </div>' +
                                '    </div>' +
                                '</div>' +

                                '');

                            setTimeout(function() {
                                $("#comment-reply-" + newComment.id).slideDown();
                                $("#comment-text").val('');
                            }, 200);

                            show_notif('success', response.data.name);
                        }
                    }
                });
            }
        })

        function addCommentReply(comment_id) {
            // var comment_id = $(this).attr("data-reply-id");
            var comment = $("#comment-reply-textbox-" + comment_id).val();

            if (comment !== "") {
                $('.overlay-loading').show();
                $.ajax({
                    url: '<?php echo base_url("activities/addCommentReply"); ?>',
                    type: "post",
                    dataType: "json",
                    data: {
                        comment: comment,
                        comment_id: comment_id,
                        project_id: <?php echo $projectDetail->id; ?>
                    },
                    success: function(response) {
                        var newReply = response.data.item;
                        $('.overlay-loading').hide();
                        if (response.result == 200) {
                            var newComment = response.data.item;
                            $("#comment-reply-text-" + comment_id).append('' +
                                '<div class="comment-reply row" id="comment-reply-text-' + newComment.id + '" style="display: none">' +
                                '    <div class="comment-reply-init">' +
                                '        <span>' + newReply.user_initial + '</span>' +
                                '    </div>' +
                                '    <div class="comment-reply-text" id="comment-reply-' + newComment.id + '">' +
                                '        <div class="comment-reply-text-box">' +
                                '            <span class="comment-name">' + newReply.user_name + '</span>' +
                                '            <span class="comment-role">' + newReply.user_divisi + '&nbsp;' + newReply.user_role + '</span>' +
                                '            <p>' + newReply.comment + '</p>' +
                                '        </div>' +
                                '        <div class="comment-reply-info">' +
                                '            <span class="comment-info-date">About a few seconds ago |</span>' +
                                '            <span class="comment-info-reply">Reply</span>' +
                                '        </div>' +
                                '    </div>' +
                                '</div>' +
                                '');

                            setTimeout(function() {
                                $("#comment-reply-text-" + newComment.id).slideDown();
                                $("#comment-reply-textbox-" + comment_id).val('');
                            }, 200);

                            show_notif('success', response.data.name);
                        }
                    }
                });
            }
        }

        $(".comment-btn-level").on("click", function() {
            var comment_id = $(this).attr("data-comment-id");

            $(".comment-reply [data-comment-id='" + comment_id + "']").show();
            $(this).hide();
        })

        $(".comment-btn-all").on("click", function() {
            $(".comment-reply").show();
            $(".comment-btn-all").hide();
        })

        $(".btn-export").on("click", function() {
            $('.overlay-loading').show();
            $.ajax({
                url: '<?php echo base_url("main/exports/activities/" . $projectDetail->slug); ?>',
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