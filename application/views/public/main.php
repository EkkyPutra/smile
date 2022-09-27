<!DOCTYPE html>
<html lang="en">

<head>
    <?php include(APPPATH . "views/layout/html_head.php"); ?>
</head>

<body>
    <?php include(APPPATH . "views/layout/header.php"); ?>

    <div class="content bg-white">
        <div class="main-page">
            <div class="main-frame row">
                <div class="main-left col-6">
                    <h1>Project</h1>
                    <h1>Monitoring</h1>
                    <h5>Monitoring aktivitas proyek yang sedang berjaan dan performa setiap PIC</h5>
                    <div class="main-left-seg row">
                        <div class="main-left-seg-item col-6">
                            <span>Proyek On Progress</span>
                            <label class="mls-num">10</label>
                        </div>
                        <div class="main-left-seg-item col-6">
                            <span>Proyek Terlambat</span>
                            <label class="mls-num">47</label>
                        </div>
                        <div class="main-left-seg-item col-6">
                            <span>Proyek Selesai</span>
                            <label class="mls-num">46</label>
                        </div>
                        <div class="main-left-seg-item col-6">
                            <span>Total Proyek</span>
                            <label class="mls-num">68</label>
                        </div>
                    </div>
                </div>
                <div class="main-right col-6">
                    <div class="main-right-red">
                        <a href="javascript:void(0);">
                            <img src="<?php echo BASE_URL . "assets/images/daftar-proyek.png"; ?>" />
                        </a>
                    </div>
                    <div class="main-right-blue">
                        <a href="javascript:void(0);">
                            <img src="<?php echo BASE_URL . "assets/images/performa-member.png"; ?>" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include(APPPATH . "views/layout/footer_script.php"); ?>
</body>

</html>