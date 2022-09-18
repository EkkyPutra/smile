<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("layout/html_head.php"); ?>
    <!-- Lightslider Style -->
    <link rel="stylesheet" href="<?php echo base_url("assets/plugins/lightSlider/css/lightslider.css"); ?>" />
</head>

<body>
    <?php include("layout/header.php"); ?>

    <div class="content">
        <div class="banner mb-4 mt-4">
            <ul id="image-gallery" class="slider list-unstyled cS-hidden">
                <?php
                if (!is_null($slider)) {
                    foreach ($slider as $slide) {
                        echo '<li>';

                        if (!is_null($slide->link) && !empty($slide->link))
                            echo '  <a href="' . $slide->link . '" target="_blank">';

                        echo '  <img style="width: 100%" src="' . base_url($slide->image) . '" />';

                        if (!is_null($slide->link) && !empty($slide->link))
                            echo '  </a>';

                        echo '</li>';
                    }
                }
                ?>
            </ul>
        </div>

        <!-- <div class="banner mb-4 mt-4">
            <img src="<?php echo base_url("assets/images/banner-arahan.png"); ?>" />
        </div> -->
        <div class="home-news mb-4">
            <div class="row">
                <div class="col-12 col-sm-8 col-md-8">
                    <div class="hn-lists-left">
                        <?php
                        if (!is_null($newsHome)) {
                            $item = $newsHome->items;
                            for ($i = 0; $i < 2; $i++) {
                                echo '<div class="hn-lists-left-item row m-0 mb-3">';
                                if (isset($item[$i])) {
                                    echo '    <label class="title-hn-lists-item-left">HIGHLIGHT BERITA</label>';
                                }
                                echo '    <div class="col-12 col-sm-6 col-md-6 p-3">';
                                echo '        <h5 class="text-bold">' . (isset($item[$i]) ? $item[$i]->name : "") . '</h5>';
                                echo '        <p><i>' . (isset($item[$i]) ? $this->myutils->convertDate($item[$i]->created) : "") . '</i> ' . (isset($item[$i]) ? character_limiter(strip_tags($item[$i]->text), 290) : "") . '</p>';
                                if (isset($item[$i])) {
                                    echo '        <a class="float-right font-weight-bold" href="' . base_url("page/berita/") . $item[$i]->slug . '">Selengkapnya &gt;&gt;</a>';
                                }
                                echo '    </div>';
                                echo '    <div class="hn-lists-left-item-image col-12 col-sm-6 col-md-6 m-0 p-0">';
                                if (isset($item[$i])) {
                                    echo '         <img src="' . base_url("files/images/berita/") . $item[$i]->images . '" class="" />';
                                }
                                echo '    </div>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="col-12 col-sm-4 col-md-4">
                    <div class="form-inline col-12" style="display: block; padding: 0; margin-bottom: 5px;">
                        <div class="input-group" data-widget="sidebar-search">
                            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-sidebar btn-primary">
                                    <i class="fas fa-search fa-fw"></i>
                                </button>
                            </div>
                        </div>
                        <div class="sidebar-search-results">
                            <div class="list-group">
                                <a href="#" class="list-group-item">
                                    <div class="search-title"><strong class="text-light"></strong>N<strong class="text-light"></strong>o<strong class="text-light"></strong> <strong class="text-light"></strong>e<strong class="text-light"></strong>l<strong class="text-light"></strong>e<strong class="text-light"></strong>m<strong class="text-light"></strong>e<strong class="text-light"></strong>n<strong class="text-light"></strong>t<strong class="text-light"></strong> <strong class="text-light"></strong>f<strong class="text-light"></strong>o<strong class="text-light"></strong>u<strong class="text-light"></strong>n<strong class="text-light"></strong>d<strong class="text-light"></strong>!<strong class="text-light"></strong></div>
                                    <div class="search-path"></div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="hn-lists-right">
                        <div class="hn-lists-right-item row m-0 mb-2" onclick="window.open('http://sipatuh.perumahan.pu.go.id/emr/')">
                            <!-- <label>Apps 1</label> -->
                            <img src="<?php echo base_url("files/images/aplikasi/apps-1.jpeg"); ?>" />
                        </div>
                        <div class="hn-lists-right-item row m-0 mb-2" onclick="window.open('http://sipatuh.perumahan.pu.go.id/sisakti/')">
                            <!-- <label>Apps 1</label> -->
                            <img src="<?php echo base_url("files/images/aplikasi/logo-sisakti.png"); ?>" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-third mb-4">
            <div class="row">
                <div class="col-12 col-sm-4 col-md-4">
                    <div class="ct-item">
                        <i class="fas fa-comments fa-5x"></i>
                        <h4 class="mt-4">KONSULTASI</h4>
                    </div>
                </div>
                <div class="col-12 col-sm-4 col-md-4">
                    <div class="ct-item">
                        <i class="fas fa-balance-scale fa-5x"></i>
                        <h4 class="mt-4">PRODUK HUKUM</h4>
                    </div>
                </div>
                <div class="col-12 col-sm-4 col-md-4">
                    <?php
                    if (!is_null($productCat->data->item->items)) {
                        $productCatData = $productCat->data->item->items[0];
                        echo '<div class="ct-item" onclick="window.location.href=\'' . base_url("page/produk/$productCatData->slug") . '\'">';
                        echo '<i class="fas fa-book-reader fa-5x"></i>';
                        echo '<h4 class="mt-4">' . strtoupper($productCatData->name) . '</h4>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php include("layout/html_footer.php"); ?>
    <?php include("layout/body_script.php"); ?>
    <!-- Lightslider -->
    <script src="<?php echo base_url("assets/plugins/lightSlider/js/lightslider.js"); ?>"></script>

    <script>
        var width = screen.width;
        var verHeight

        if (width >= 1600)
            verHeight = 480;
        else
            verHeight = 320;

        $('#image-gallery').lightSlider({
            item: 1,
            slideMargin: 0,
            auto: true,
            loop: true,
            verticalHeight: verHeight,
            pager: false,
            prevHtml: "<i class='fa fa-chevron-left'></i>",
            nextHtml: "<i class='fa fa-chevron-right'></i>",
            onSliderLoad: function() {
                $('#image-gallery').removeClass('cS-hidden');
            }
        });
    </script>
</body>

</html>