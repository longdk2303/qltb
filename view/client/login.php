<?php
if (!empty($User_data)) {
    moveUrl("/client/home");
}
?>
<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>Đăng Nhập hệ thống</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">

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
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="<?= BASE_URL("/assets/client/css/style.css") ?>" id="main-style-link">
    <link rel="stylesheet" href="<?= BASE_URL("/assets/client/css/style-preset.css") ?>">

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
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

    <div class="auth-main">
        <div class="auth-wrapper v1">
            <div class="auth-form">
                <div class="card my-5">
                    <div class="card-body">
                        <div class="text-center">
                            <a href="#"><img src="<?= BASE_URL("/assets/client/images/logo-dark.svg") ?>" alt="img"></a>
                        </div>
                        <div class="saprator my-3">
                        </div>
                        <h4 class="text-center f-w-500 mb-3">Đăng Nhập hệ thống</h4>
                        <div class="form-group mb-3">
                            <input type="email" class="form-control" id="username" placeholder="Tài Khoản or email">
                        </div>
                        <div class="form-group input-affix flex-column" style="position: relative;">
                            <input type="password" class="form-control" id="password" placeholder="Mật Khẩu">
                            <i class="suffix-icon text-dark fa fa-eye-slash toggle-password"
                                style="cursor: pointer; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);"></i>
                        </div>
                        <div class="d-flex mt-1 justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input input-primary" type="checkbox" id="customCheckc1"
                                    checked="">
                                <label class="form-check-label text-muted" for="customCheckc1">Remember me?</label>
                            </div>
                            <h6 class="text-secondary f-w-400 mb-0">Forgot Password?</h6>
                        </div>
                        <div class="d-grid mt-4">
                            <button id="loginSubmitButton" type="button" class="btn btn-primary">Đăng Nhập</button>
                        </div>
                        <div class="d-flex justify-content-between align-items-end mt-4">
                            <h6 class="f-w-500 mb-0">Bạn Chưa có tài khoản?</h6>
                            <a href="<?= BASE_URL("/client/register") ?>" class="link-primary">Đăng Ký Ngay</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
    <!-- Required Js -->
    <script src="<?= BASE_URL("/assets/client/js/plugins/popper.min.js") ?>"></script>
    <script src="<?= BASE_URL("/assets/client/js/plugins/simplebar.min.js") ?>"></script>
    <script src="<?= BASE_URL("/assets/client/js/plugins/bootstrap.min.js") ?>"></script>
    <script src="<?= BASE_URL("/assets/client/js/fonts/custom-font.js") ?>"></script>
    <script src="<?= BASE_URL("/assets/client/js/pcoded.js") ?>"></script>
    <script src="<?= BASE_URL("/assets/client/js/plugins/feather.min.js") ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@latest"></script>

    <script>
        const LoginSubmit = document.getElementById('loginSubmitButton');

        LoginSubmit.addEventListener('click', function(event) {
            event.preventDefault();
            const user = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            if (!user || !password) {
                Swal.fire({
                    icon: "warning",
                    title: "Cảnh báo!",
                    text: "Vui lòng nhập tên người dùng và mật khẩu.",
                    confirmButtonText: 'OK'
                });
                return;
            }

            LoginSubmit.disabled = true;

            Swal.fire({
                title: 'Đang xử lý',
                text: 'Vui lòng đợi trong khi chúng tôi xử lý yêu cầu của bạn.',
                icon: 'info',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            fetch('<?= BASE_URL("/ajaxs/auth?submit=login") ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        account: user,
                        password: password,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error != 0) {
                        Swal.fire({
                            icon: "error",
                            title: "Đăng Nhập Thất Bại!",
                            text: data.message,
                            confirmButtonText: 'Thử lại'
                        });
                        LoginSubmit.disabled = false;
                    } else {
                        Swal.fire({
                            icon: "success",
                            title: "Đăng Nhập Thành Công!",
                            text: data.message,
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    }
                })
                .catch((error) => {
                    Swal.fire({
                        title: 'Đã Xảy Ra Lỗi!',
                        text: 'Vui lòng thử lại sau ít phút hoặc kiểm tra kết nối của bạn.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            LoginSubmit.disabled = false;
                        }
                    });
                });
        });

        jQuery(document).ready(function($) {
            $('.toggle-password').on('click', function() {
                let input = $(this).closest('.form-group').find('input');
                if (input.attr('type') == 'password') {
                    input.attr('type', 'text');
                    $(this).removeClass('fa-eye-slash').addClass('fa-eye');
                } else {
                    input.attr('type', 'password');
                    $(this).removeClass('fa-eye').addClass('fa-eye-slash');
                }
            });
        });
        document.addEventListener('keypress', function(event) {
            // Kiểm tra phím nhấn là Enter và không có lớp phủ của SweetAlert đang hiển thị
            if (event.key === 'Enter' && document.querySelector('.swal2-container') === null) {
                LoginSubmit.click();
            }
        });
    </script>
    <script>
        layout_change('light');
        layout_theme_contrast_change('false');
        change_box_container('false');
        layout_caption_change('true');
        layout_rtl_change('false');
        preset_change("preset-1");
    </script>

</body>
<!-- [Body] end -->

</html>