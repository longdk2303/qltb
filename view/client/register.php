<?php
if (!empty($User_data)) {
    moveUrl("/client/home");
}
?>
<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>Đăng ký tài khoản</title>
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
                        <h4 class="text-center f-w-500 mb-3">Đăng Ký tài khoản</h4>
                        <div class="form-group mb-3">
                            <input id="username" type="text" class="form-control" placeholder="Username">
                        </div>
                        <div class="form-group mb-3">
                            <input id="password" type="password" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group mb-3">
                            <input id="rePassword" type="password" class="form-control" placeholder="Confirm Password">
                        </div>
                        <div class="d-flex mt-1 justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input input-primary" type="checkbox" id="customCheckc1"
                                    checked="">
                                <label class="form-check-label text-muted" for="customCheckc1">I agree to all the Terms
                                    &amp; Condition</label>
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <button id="registserSubmitButton" type="button" class="btn btn-primary">Đăng ký</button>
                        </div>
                        <div class="d-flex justify-content-between align-items-end mt-4">
                            <h6 class="f-w-500 mb-0">Đã Có tài khoản?</h6>
                            <a href="<?= BASE_URL("/client/login") ?>" class="link-primary">Đăng nhập ngay</a>
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
        const registserSubmit = document.getElementById('registserSubmitButton');

        registserSubmit.addEventListener('click', function(event) {
            event.preventDefault();
            const user = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const rePassword = document.getElementById('rePassword').value;

            if (!user || !password) {
                Swal.fire({
                    icon: "warning",
                    title: "Cảnh báo!",
                    text: "Vui lòng nhập đầy đủ thông tin.",
                    confirmButtonText: 'OK'
                });
                return;
            }
            if (password != rePassword) {
                Swal.fire({
                    icon: "error",
                    title: "Lỗi!",
                    text: "Mật Khẩu Xác Nhận Không Chính Xác.",
                    confirmButtonText: 'OK'
                });
                return;
            }

            registserSubmit.disabled = true;

            Swal.fire({
                title: 'Đang xử lý',
                text: 'Vui lòng đợi trong khi chúng tôi xử lý yêu cầu của bạn.',
                icon: 'info',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            fetch('<?= BASE_URL("/ajaxs/auth?submit=register") ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        account: user,
                        password: password,
                        password_confirmation: rePassword,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error != 0) {
                        Swal.fire({
                            icon: "error",
                            title: "Đăng Ký Thất Bại!",
                            text: data.message,
                            confirmButtonText: 'Thử lại'
                        });
                        registserSubmit.disabled = false;
                    } else {
                        Swal.fire({
                            icon: "success",
                            title: "Đăng Ký Thành Công!",
                            text: data.message,
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "../login.php";
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
                            registserSubmit.disabled = false;
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
            if (event.key === 'Enter' && document.querySelector('.swal2-container') === null) {
                registserSubmit.click();
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