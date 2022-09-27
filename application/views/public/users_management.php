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

    <div class="content">
        <div class="profile-page">
            <!-- SELECT2 EXAMPLE -->
            <div class="card card-default">
                <!-- .card-header -->
                <div class="card-header no-sub">
                    <div class="seg-tools">
                        <i class="fas fa-arrow-left"></i>
                    </div>
                    <h3 class="seg-title">User Management</h3>
                </div>
                <!-- /.card-header -->
                <!-- .card-body -->
                <div class="card-body">
                    <div id="toolbar">
                        <button id="remove" class="btn btn-danger" disabled>
                            <i class="fa fa-trash"></i> Delete
                        </button>
                        <button id="remove" class="btn btn-primary" onclick="addNewProduct();">
                            <i class="far fa-plus-square"></i> Tambah
                        </button>
                    </div>
                    <table id="tableUsersLists" class="table" data-ajax="getData">
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
    <script>
        var $table = $('#tableUsersLists');
        var $remove = $('#remove');
        var selections = [];

        var userTable = $("#tableUsersLists").DataTable({
            processing: true,
            serverSide: true,
            columnDefs: [{
                    targets: 0,
                    width: "5%",
                    orderable: false
                },
                {
                    targets: 1,
                    width: "10%",
                    orderable: false
                },
                {
                    targets: 2,
                    width: "25%",
                    className: "pt-4"
                },
                {
                    targets: 3,
                    width: "15%",
                    className: "pt-4"
                },
                {
                    targets: 4,
                    width: "15%",
                    className: "pt-4"
                },
                {
                    targets: 5,
                    width: "20%",
                    className: "pt-4"
                },
                {
                    targets: 6,
                    width: "10%",
                    className: "pt-4"
                }
            ],
            paging: true,
            pagingType: "simple_numbers",
            deferRender: true,
            language: {
                paginate: {
                    next: '<span class="btn btn-default"><i class="fas fa-chevron-right"></i></span>',
                    previous: '<span class="btn btn-default"><i class="fas fa-chevron-left"></i></span>'
                },
                buttons: {
                    pageLength: {
                        _: "<i class='fas fa-eye'></i> %d éléments",
                        '-1': "Tout afficher"
                    }
                }
            },
            dom: 'Bfrtip',
            lengthMenu: [
                [10, 25, 50, -1],
                ['10 rows', '25 rows', '50 rows', 'Show all']
            ],
            buttons: [
                'pageLength'
            ],
            bPaginate: true,
            sPaginationType: "custom",
        });

        // $(document).ready(function() {
        //     $('#tableUsersLists').DataTable({
        //         ajax: {
        //             method: "GET",
        //             url: "<?php echo base_url("users/getData"); ?>",
        //             "data": function() {
        //                 return requestData;
        //             },
        //             dataSrc: "",
        //         },
        //     });
        // });

        // function ajaxRequest(params) {
        //     var url = '<?php echo base_url("users/getData"); ?>';
        //     $.get(url + '?' + $.param(params.data)).then(function(res) {
        //         params.success(res)
        //     })
        // }

        // function getIdSelections() {
        //     return $.map($table.bootstrapTable('getSelections'), function(row) {
        //         return row.id
        //     })
        // }

        // $table.on('check.bs.table uncheck.bs.table ' +
        //     'check-all.bs.table uncheck-all.bs.table',
        //     function() {
        //         $remove.prop('disabled', !$table.bootstrapTable('getSelections').length)

        //         // save your data, here just save the current page
        //         selections = getIdSelections()
        //         // push or splice the selections if you want to save all data selections
        //     }
        // )

        // $(function() {
        //     $("input[data-bootstrap-switch]").each(function() {
        //         $(this).bootstrapSwitch('state', $(this).prop('checked'));
        //     })
        // });
    </script>
</body>

</html>