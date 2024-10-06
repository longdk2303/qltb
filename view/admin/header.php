<?php
if (empty($User_data) || $User_data['role_id'] != 2) {
    moveUrl("/client/login");
}
?>
<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title><?= $title ?? "" ?></title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- [Favicon] icon -->
    <link rel="icon" href="<?= BASE_URL("/assets/admin/images/favicon.svg") ?>" type="image/x-icon">
    <!-- [Font] Family -->
    <link rel="stylesheet" href="<?= BASE_URL("/assets/admin/fonts/inter/inter.css") ?>" id="main-font-link" />
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="<?= BASE_URL("/assets/admin/fonts/tabler-icons.min.css") ?>">
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="<?= BASE_URL("/assets/admin/fonts/feather.css") ?>">
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="<?= BASE_URL("/assets/admin/fonts/fontawesome.css") ?>">
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="<?= BASE_URL("/assets/admin/fonts/material.css") ?>">
    <!-- dataTables.bootstrap5.min.css -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.bootstrap5.css">
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="<?= BASE_URL("/assets/admin/css/style.css?time=" . time()) ?>" id="main-style-link">
    <link rel="stylesheet" href="<?= BASE_URL("/assets/admin/css/style-preset.css?time=" . time()) ?>">

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <?= $header ?>
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
            <div class="m-header">
                <div class="text-center">
                    <a href=""><img src="<?= BASE_URL("/assets/client/images/logo-dark.svg") ?>" alt="img"></a>
                </div>
            </div>

            <div class="navbar-content">
                <ul class="pc-navbar">
                    <li class="pc-item pc-hasmenu">
                        <a href="<?= BASE_URL("/admin/home") ?>" class="pc-link">
                            <span class="pc-micon">
                                <i class="ti ti-shopping-cart-plus"></i>
                            </span>
                            <span class="pc-mtext">Đơn hàng</span><span class="pc-arrow">
                            </span></a>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="#" class="pc-link">
                            <span class="pc-micon">
                                <i class="ti ti-shopping-cart-plus"></i>
                            </span>
                            <span class="pc-mtext">Quản lý sản phẩm</span><span class="pc-arrow">
                                <i data-feather="chevron-right"></i>
                            </span></a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link"
                                    href="<?= BASE_URL("/admin/product/category") ?>">Danh mục sản phẩm</a></li>
                            <li class="pc-item"><a class="pc-link" href="<?= BASE_URL("/admin/product/list") ?>">Danh
                                    sách sản phẩm</a></li>

                        </ul>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="<?= BASE_URL("/admin/users/list") ?>" class="pc-link active">
                            <span class="pc-micon">
                                <i class="ti ti-user"></i>
                            </span>
                            <span class="pc-mtext">Quản Lý Người Dùng</span><span class="pc-arrow">
                                <!-- <i data-feather="chevron-right"></i> -->
                            </span></a>
                    </li>
                </ul>
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
                <ul class="list-unstyled">
                    <li class="dropdown pc-h-item header-user-profile">
                        <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                            <img src="<?= BASE_URL("/assets/admin/images/user/avatar-2.jpg") ?>" alt="user-image"
                                class="user-avtar" />
                        </a>
                        <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                            <div class="dropdown-body">
                                <div class="profile-notification-scroll position-relative">

                                    <a href="<?= BASE_URL('/client/logout') ?>" class="dropdown-item">
                                        <span>
                                            <i class="ti ti-power"></i>
                                            <span>Đăng Xuất</span>
                                        </span>
                                    </a>
                                </div>
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