<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_GET) && !empty($_GET['submit'])) {
    $data = json_decode(file_get_contents("php://input"), true);
    if (is_array($data)) {
        $_POST = xss_array($data);
    }

    function Login($data)
    {
        global $db, $session;
        $account = ($data['account']) ?? null;
        $password = ($data['password']) ?? null;
        if ((empty($account) && empty($email)) || empty($password)) {
            exit(json_encode(returnData(null, "Chưa Nhập Tài khoản hoặc mật khẩu thử lại sau!")));
        }
        $dataUser = $db->fetch_assoc("SELECT `id`, `active` FROM users WHERE `username` = '$account' AND `password` = '" . md5($password) . "'", 1);
        if (empty($dataUser)) {
            exit(json_encode(returnData(null, "Tài Khoản hoặc Mật Khẩu không chính xác!")));
        }

        if ($dataUser['active'] != "active") {
            exit(json_encode(returnData(null, "Tài Khoản đã bị khóa!")));
        }

        $session->send('account', $dataUser['id']);
        exit(json_encode(returnData($dataUser, "Đăng Nhập thành công!")));
    }

    function Register($data)
    {
        global $db;
        $account = ($data['account']) ?? null;
        $password = ($data['password']) ?? null;
        $password_confirmation = ($data['password_confirmation']) ?? null;

        if (empty($account) || empty($password) || empty($password_confirmation)) {
            exit(json_encode(returnData(null, "Vui lòng điền đầy đủ thông tin...")));
        }
        if ($password != $password_confirmation) {
            exit(json_encode(returnData(null, "Mật Khẩu Xác Nhận không chính xác...")));
        }
        if (!CheckData($account, 'username')) {
            exit(json_encode(returnData(null, "Tên người dùng phải từ 3 đến 16 ký tự và chỉ chứa chữ cái và số.")));
        }
        if (!CheckData($password, 'password')) {
            exit(json_encode(returnData(null, "Mật khẩu phải chứa ít nhất một chữ cái viết hoa, một chữ cái viết thường, một chữ số và một ký tự đặc biệt.")));
        }

        $dataUser = $db->fetch_assoc("SELECT `id` FROM users WHERE `username` = '$account'", 1);
        if (!empty($dataUser)) {
            exit(json_encode(returnData(null, "Tài khoản đã tồn tại trên hệ thống. Vui lòng nhập lại.")));
        }
        $db->insert('users', [
            'username'          => $account,
            'password'          => md5($password)
        ]);
        exit(json_encode(returnData(['status' => 'success'], "Đăng Ký thành công!")));
    }
    function repass($data)
    {
        global $db, $User_data;
        $id                 = ($data['pin']) ?? null;
        $old_password       = ($data['old_password']) ?? null;
        $new_password       = ($data['new_password']) ?? null;
        $password_confirm   = ($data['password_confirm']) ?? null;
        if ($User_data['id'] != $id) {
            exit(json_encode(returnData(null, "không thể xác thực người dùng!!!")));
        }
        if (empty($old_password) || empty($new_password) || empty($id) || empty($password_confirm)) {
            exit(json_encode(returnData(null, "Vui lòng nhập đầy đủ thông tin!")));
        }
        if ($new_password == $old_password) {
            exit(json_encode(returnData(null, "Mật Khẩu mới không được trúng với mật khẩu cũ!")));
        }
        $dataUser = $db->fetch_assoc("SELECT id FROM users WHERE `id` = '" . $id . "' AND `password` = '" . md5($old_password) . "'", 1);
        if (empty($dataUser)) {
            exit(json_encode(returnData(null, "Mật Khẩu không chính xác!")));
        }
        if ($new_password != $password_confirm) {
            exit(json_encode(returnData(null, "Mật Khẩu xác thực không chính xác vui lòng thử lại!")));
        }
        $db->update('users', [
            'password' => md5($new_password),
        ], "`id` = '" . $dataUser['id'] . "'");
        exit(json_encode(returnData($dataUser, "Đổi mật khẩu thành công!")));
    }
    switch ($_GET['submit']) {
        case "login":
            Login($_POST);
        case "register":
            Register($_POST);
        case "repass":
            repass($_POST);
    }
}