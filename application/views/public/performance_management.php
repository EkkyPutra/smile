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
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <!-- .card-header -->
                <div class="card-header no-sub">
                    <div class="seg-tools" onclick="window.location.href='<?php echo base_url(); ?>'">
                        <i class="fas fa-arrow-left"></i>
                    </div>
                    <div class="row">
                        <h3 class="col-sm-6 col-8 seg-title">Performa Member</h3>
                        <div class="toolHead col-sm-6 col-4 float-right text-right mb-1">
                            <button class="btn btn-export"><i class="fas fa-upload"></i> <span>Export File</span></button>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <!-- .card-body -->
                <div class="card-body">
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
                        <div class="toolbar-select">
                            <span><i class="fas fa-filter"></i> Filters</span>
                            <select id='user_divisi' class="form-control">
                                <option value=''>-- Divisi --</option>
                                <?php
                                foreach ($usersDivisi as $divisi) {
                                    echo "<option value='" . strtolower($divisi->value) . "'>" . $divisi->value . "</option>";
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
                        <table id="tableMembersLists" class="table table-borderless"></table>
                    <?php } else { ?>
                        <table id="tableMembersLists" class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama PIC</th>
                                    <th>Divisi</th>
                                    <th>Proyek On Track</th>
                                    <th>Proyek Terlambat</th>
                                    <th>Proyek Selesai</th>
                                    <th>Aksi</th>
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
        var $userTable = $('#tableMembersLists');

        function fetchTable(user_divisi, page, limit, refresh = false, params = []) {
            var limit = $('#pageLength').find(":selected").val();
            var start = (page == 0) ? ($(".paginationX.pCurrent").attr("data-start")) : page;
            var infoX = ((parseInt(start) - 1) * limit) + 1;
            var infoY = parseInt(start) * limit;
            var currPage = $(".paginationX.pCurrent").attr("data-page");

            $("#infoX").text(infoX);
            $.ajax({
                url: "<?php echo base_url("performances/getData"); ?>",
                type: "POST",
                data: {
                    user_divisi: user_divisi,
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

                    if (res.isMobile) {
                        var tableColumns = [{
                            data: "data",
                            width: "100%"
                        }];
                    } else {
                        var tableColumns = [{
                                data: "id",
                                width: "4%",
                                orderable: false
                            },
                            {
                                data: "name",
                                width: "25%",
                                className: "pt-4"
                            },
                            {
                                data: "user_divisi",
                                width: "13%",
                                className: "pt-4"
                            },
                            {
                                data: "project.ontrack",
                                width: "17%",
                                className: "pt-4"
                            },
                            {
                                data: "project.complete",
                                width: "17%",
                                className: "pt-4"
                            },
                            {
                                data: "project.late",
                                width: "17%",
                                className: "pt-4"
                            },
                            {
                                data: "action",
                                width: "7%",
                                className: "pt-4"
                            }
                        ];
                    }
                    $("#tableMembersLists").DataTable({
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

        $("#user_divisi").on("change", function(e) {
            e.preventDefault();
            $(".card-body").focusin();

            var user_divisi = $("#user_divisi").val();
            $('#tableMembersLists').DataTable().destroy();
            fetchTable(user_divisi);
        });

        $("#pageLength").on("change", function(e) {
            e.preventDefault();

            var limit = $(this).val();
            var user_divisi = $("#user_divisi").val();
            $("#pageLength option").removeAttr("selected");
            $("#pageLength").find("option[value='" + limit + "']").attr("selected", true);
            $('#tableMembersLists').DataTable().destroy();
            fetchTable(user_divisi, 1, limit, true);
        })

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
            fetchTable($("#user_divisi").val(), 1, $("#pageLength").find(":selected").val(), true);
            // generatePagination(1);
        })

        $(document).on("click", ".paginationX", function() {
            var currPage = $(".paginationX.pCurrent").attr("data-page");
            var clickPage = $(this).attr("data-page");
            var limit = $("#pageLength").find(":selected").val();
            var user_divisi = $("#user_divisi").val();

            if (!$(this).hasClass("pCurrent")) {
                $(".overlay-loading").show();
                if (currPage != clickPage) {
                    $('#tableMembersLists').DataTable().destroy();
                    fetchTable(user_divisi, clickPage, limit, true);
                    setTimeout(function() {
                        $(".overlay-loading").hide();
                    }, 200);
                }
            }
        })

        $(document).on("click", "#bPaginationPrev", function() {
            var currPage = $(".paginationX.pCurrent").attr("data-page");
            var clickPage = parseInt(currPage) - 1;
            var limit = $("#pageLength").find(":selected").val();
            var user_divisi = $("#user_divisi").val();

            if (!$(this).hasClass("bDisabled")) {
                $(".overlay-loading").show();
                if (currPage != clickPage && $("#bPaginationPrev").attr("class") !== "bDisabled") {
                    $('#tableMembersLists').DataTable().destroy();
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
                    $('#tableMembersLists').DataTable().destroy();
                    fetchTable(user_divisi, clickPage, limit, true);
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
            $("#user_divisi option").removeAttr("selected");
            $("#user_divisi").val($("#user_divisi option:first").val());
            $("#user_divisi").find("option[value='" + $("#user_divisi option:first").val() + "']").attr("selected", true);
            $('#tableMembersLists').DataTable().destroy();
            fetchTable("", 1, 1, true);

        })

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
                    url: "<?php echo base_url("performances/getData"); ?>",
                    type: "POST",
                    data: {
                        params: params,
                        start: start,
                        limit: limit
                    },
                    dataType: "json",
                    success: function(res) {
                        var user_divisi = $("#user_divisi").val();
                        $('#tableMembersLists').DataTable().destroy();
                        fetchTable(user_divisi, 1, limit, true, params);
                    }


                });
            }
        })

        $(".btn-export").on("click", function() {
            $('.overlay-loading').show();
            $.ajax({
                url: '<?php echo base_url("main/exports/performances"); ?>',
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