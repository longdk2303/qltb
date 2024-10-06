    <?php

    if (empty($User_data)) {
        moveUrl("/client/login");
    }

    if ($User_data['role_id'] == 2) {
        moveUrl("/admin/home");
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <!-- [Head] start -->

    <head>
        <title><?= $title ? $title : "Trang chủ" ?></title>
        <!-- [Meta] -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- [Favicon] icon -->
        <link rel="icon" href="<?= BASE_URL("/assets/client/images/favicon.svg") ?>" type="image/x-icon">
        <!-- [Font] Family -->
        <link rel="stylesheet" href="<?= BASE_URL("/assets/client/fonts/inter/inter.css") ?>" id="main-font-link" />
        <!-- [Tabler Icons] https://tablericons.com -->
        <link rel="stylesheet" href="<?= BASE_URL("/assets/client/fonts/tabler-icons.min.css") ?>">
        <!-- [Feather Icons] https://feathericons.com -->
        <link rel="stylesheet" href="<?= BASE_URL("/assets/client/fonts/feather.css") ?>">
        <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
        <link rel="stylesheet" href="<?= BASE_URL("/assets/client/fonts/fontawesome.css") ?>">
        <!-- [Material Icons] https://fonts.google.com/icons -->
        <link rel="stylesheet" href="<?= BASE_URL("/assets/client/fonts/material.css") ?>">
        <!-- dataTables.bootstrap5.min.css -->
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.bootstrap5.css">
        <!-- [Template CSS Files] -->
        <link rel="stylesheet" href="<?= BASE_URL("/assets/client/css/style.css?time=" . time()) ?>"
            id="main-style-link">
        <link rel="stylesheet" href="<?= BASE_URL("/assets/client/css/style-preset.css?time=" . time()) ?>">

        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <?= $header ?>
    </head>
    </head>
    <!-- [Head] end -->
    <!-- [Body] Start -->

    <body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme_contrast=""
        data-pc-theme="light">
        <!-- [ Pre-loader ] start -->
        <div class="loader-bg">
            <div class="loader-track">
                <div class="loader-fill"></div>
            </div>
        </div>
        <!-- [ Pre-loader ] End -->
        <!-- [ Sidebar Menu ] start -->
        <nav class="pc-sidebar">
            <div class="navbar-wrapper">

                <div class="navbar-content">
                    <div class="card pc-user-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="<?= BASE_URL("/assets/client/images/user/avatar-1.jpg") ?>"
                                        alt="user-image" class="user-avtar wid-45 rounded-circle" />
                                </div>
                                <div class="flex-grow-1 ms-3 me-2">
                                    <h6 class="mb-0"><small><?= $User_data['username'] ?? "Người Dùng" ?></small></h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="pc-navbar">
                        <li class="pc-item pc-hasmenu">
                            <a href="<?= BASE_URL("/client/home") ?>" class="pc-link">
                                <span class="pc-micon">
                                    <i class="ti ti-home"></i>
                                </span>
                                <span class="pc-mtext">Trang Chủ</span><span class="pc-arrow">
                                </span></a>
                        </li>
                        <?php if (!empty($User_data)) { ?>
                            <li class="pc-item pc-hasmenu">
                                <a href="<?= BASE_URL("/client/history") ?>" class="pc-link active">
                                    <span class="pc-micon">
                                        <i class="ti ti-history"></i>
                                    </span>
                                    <span class="pc-mtext">Sản Phẩm Đã Thuê</span><span class="pc-arrow">
                                        <!-- <i data-feather="chevron-right"></i> -->
                                    </span></a>
                                <!-- <ul class="pc-submenu">
                                <li class="pc-item"><a class="pc-link" href="">Quản Lý Proxy</a></li>
                            </ul> -->
                            </li>
                        <?php } else { ?>
                            <li class="pc-item pc-hasmenu">
                                <a href="<?= BASE_URL('/client/login') ?>" class="pc-link">
                                    <span class="pc-micon">
                                        <i class="ti ti-login"></i>
                                    </span>
                                    <span class="pc-mtext">Đăng nhập</span><span class="pc-arrow">
                                    </span></a>
                            </li>
                        <?php
                        } ?>
                    </ul>
                    <div class="card nav-action-card bg-brand-color-4">
                        <div class="card-body"
                            style="background-image: url('<?= BASE_URL("/assets/client/images/layout/nav-card-bg.svg") ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                            <h5 class="text-dark">Hỗ Trợ</h5>
                            <p class="text-dark text-opacity-75">Hãy Liên Hệ Với chúng tôi nếu cần hỗ trợ.</p>
                            <a href="" class="btn btn-primary" target="_blank">Liên
                                Hệ Ngay</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <!-- [ Sidebar Menu ] end -->
        <!-- [ Header Topbar ] start -->
        <header class="pc-header">
            <div class="header-wrapper">
                <!-- [Mobile Media Block] start -->
                <div class="me-auto pc-mob-drp">
                    <ul class="list-unstyled">
                        <li class="pc-h-item pc-sidebar-collapse">
                            <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="pc-h-item pc-sidebar-popup">
                            <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- [Mobile Media Block end] -->
                <div class="ms-auto">
                    <ul class="list-unstyled d-flex align-items-center">
                        <!-- Phần thông báo -->
                        <li class="dropdown pc-h-item">
                            <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                                role="button" aria-haspopup="false" aria-expanded="false">
                                <!-- <svg class="pc-icon">
                                    <use xlink:href="#custom-notification"></use>
                                </svg> -->
                                <i class="ti ti-bell"></i>
                                <span class="badge bg-success pc-h-badge">1</span>
                            </a>
                            <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
                                <div class="dropdown-header d-flex align-items-center justify-content-between">
                                    <h5 class="m-0">Thông Báo</h5>
                                </div>
                                <?php $messages = $db->fetch_assoc("SELECT * from `message` where `user_id` ='" . $User_data['id'] . "' ORDER BY created_at desc", 0) ?>
                                <div class="dropdown-body text-wrap header-notification-scroll position-relative"
                                    style="max-height: calc(100vh - 215px)">
                                    <div class="card mb-2">
                                        <div class="card-body">
                                            <div class="d-flex flex-column">
                                                <!-- <div class="flex-shrink-0">
                                                    <svg class="pc-icon text-primary">
                                                        <use xlink:href="#custom-layer"></use>
                                                    </svg>
                                                </div> -->
                                                <?php foreach ($messages as $mess) {
                                                ?>
                                                    <div class="col-12 border-bottom mb-3">
                                                        <span
                                                            class="float-end text-sm text-muted"><?= calTime($mess['created_at']) ?></span>
                                                        <h5 class="text-body mb-2"><?= $mess['title'] ?></h5>
                                                        <p class="mb-0 text-info"><?= $mess['text'] ?></p>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center py-2">
                                    <!-- <a href="#!" class="link-danger">Xóa All Thông Báo</a> -->
                                </div>
                            </div>
                        </li>
                        <!-- Phần người dùng -->
                        <li class="dropdown pc-h-item header-user-profile">
                            <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                                role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                                <img src="<?= BASE_URL("/assets/client/images/user/avatar-2.jpg") ?>" alt="user-image"
                                    class="user-avtar" />
                            </a>
                            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                                <div class="dropdown-header d-flex align-items-center justify-content-between">
                                    <h5 class="m-0">Profile</h5>
                                </div>
                                <div class="dropdown-body">
                                    <?php if (!empty($User_data)) { ?>
                                        <div class="profile-notification-scroll position-relative"
                                            style="max-height: calc(100vh - 225px)">
                                            <div class="d-flex mb-1">
                                                <div class="flex-shrink-0">
                                                    <img src="<?= BASE_URL("/assets/client/images/user/avatar-2.jpg") ?>"
                                                        alt="user-image" class="user-avtar wid-35" />
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1"><small><?= $User_data['username'] ?? "Người Dùng" ?> 🖖
                                                    </h6>
                                                    <span
                                                        class="mb-1"><small><?= empty($User_data['email']) ? "Chưa có email" : $User_data['email'] ?></small></span>
                                                </div>
                                            </div>
                                            <hr class="border-secondary border-opacity-50" />
                                            <!-- <a href="" class="dropdown-item">
                                            <span>
                                                <svg class="pc-icon text-muted me-2">
                                                    <use xlink:href="#custom-setting-outline"></use>
                                                </svg>
                                                <span>Trang cá nhân</span>
                                            </span>
                                        </a> -->
                                            <!-- <a href="" class="dropdown-item">
                                            <span>
                                                <svg class="pc-icon text-muted me-2">
                                                    <use xlink:href="#custom-lock-outline"></use>
                                                </svg>
                                                <span>Change Password</span>
                                            </span>
                                        </a> -->
                                            <a href="<?= BASE_URL('/client/logout') ?>" class="dropdown-item">
                                                <span>
                                                    <i class="ti ti-power"></i>
                                                    <span>Đăng Xuất</span>
                                                </span>
                                            </a>
                                        </div>

                                    <?php } else { ?>
                                        <div>
                                            <a href="<?= BASE_URL('/client/login') ?>" class="dropdown-item">
                                                <span>
                                                    <i class="ti ti-login"></i>
                                                    <span>Đăng Nhập</span>
                                                </span>
                                            </a>
                                        </div>
                                    <?php
                                    } ?>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>

            </div>
        </header>
        <!-- [ Header ] end -->
        <!-- [ Main Content ] start -->
        <div class="pc-container">
            <div class="pc-content">