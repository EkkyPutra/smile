<div class="header">
    <nav class="navbar navbar-expand">
        <div class="logo col-sm-3" onclick="window.location.href='<?php echo base_url(); ?>'">
            <div class="logo-icon">
                <img src="<?php echo BASE_URL . "assets/images/logo-icon-smile.png"; ?>" />
            </div>
            <div class="logo-smile">
                <img src="<?php echo BASE_URL . "assets/images/logo-smile.png"; ?>" />
            </div>
        </div>
        <div class="menu col-6">
            <ul class="navbar-menu col-12">
                <li class="nav-item d-none d-sm-inline-block"><a href="<?php echo BASE_URL . "projects/management"; ?>" <?php echo ($this->uri->segment(1) == "projects") ? 'class="active"' : ''; ?>>Daftar Proyek</a></li>
                <li class="nav-item d-none d-sm-inline-block"><a href="<?php echo BASE_URL . "performances/management"; ?>" <?php echo ($this->uri->segment(1) == "performances") ? 'class="active"' : ''; ?>>Performa Member</a></li>
                <li class="nav-item d-none d-sm-inline-block"><a href="<?php echo BASE_URL . "users/management"; ?>" <?php echo ($this->uri->segment(1) == "users") ? 'class="active"' : ''; ?>>User Management</a></li>
            </ul>
        </div>
        <div class="user-nav col-3">
            <div class="nav-item dropdown">
                <?php
                $profile = $this->session->userdata("smile.pm");
                ?>
                <div class="nav-user row" data-toggle="dropdown" aria-expanded="false">
                    <div class="user-char">
                        <?php echo substr($profile["name"], 0, 1); ?>
                    </div>
                    <div class="user-profile">
                        <label class="user-name"><?php echo $profile["name"]; ?></label>
                        <span>User <?php echo $profile["divisi"]; ?></span>
                    </div>
                    <div class="pt-3 pb-3 ml-3">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
                <div class="dropdown-menu dropdown-menu-md dropdown-menu-right user-dropdown" style="left: inherit; right: 0px;">
                    <a href="<?php echo BASE_URL . "users/profile"; ?>" class="dropdown-item pt-3 pb-3">
                        <div class="media">
                            <i class="far fa-user"></i>
                            <h3 class="dropdown-item-title ml-3">
                                Profil Saya
                            </h3>
                        </div>
                    </a>
                    <a href="<?php echo BASE_URL . "users/doLogout"; ?>" class="dropdown-item pt-3 pb-3">
                        <div class="media">
                            <i class="fas fa-sign-out-alt"></i>
                            <h3 class="dropdown-item-title ml-3">
                                Logout
                            </h3>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</div>