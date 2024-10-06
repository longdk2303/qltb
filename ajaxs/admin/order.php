<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_GET) && !empty($_GET['submit'])) {
    $data = json_decode(file_get_contents("php://input"), true);
    if (is_array($data)) {
        $_POST = xss_array($data);
    }

    function update($data)
    {
        global $db;
        if (empty($data['id']) || empty($data['status1'])) {
            exit(json_encode(returnData([], "Vui lòng nhập đầy đủ thông tin!")));
        }

        $db->update('rental_requests', ['status1' => $data['status1'], 'status2' => $data['status2']], "`id`='" . $data['id'] . "'");
        $info = $db->fetch_assoc("SELECT * FROM rental_requests where `id`='" . $data['id'] . "'", 1);
        $pro = $db->fetch_assoc("select * from products where `id`='" . $info['product_id'] . "'", 1);
        if ($data['status1'] == 'refuse' || $data['status2'] == "paid") {
            $db->update('products', ['quantity' => $pro['quantity'] + 1], "`id`='" . $info['product_id'] . "'");
        }

        if ($data['status1'] != 'pending') {
            $status = $data['status1'] == 'success' ? 'đã được xác nhận' : 'đã bị hủy';
            $text = 'Đơn hàng #' . $info['id'] . ' của bạn ' . $status . ' bởi quản trị viên.';
            $db->insert("message", ['user_id' => $info['user_id'], 'text' => $text, 'title' => 'Đơn hàng']);
        }
        exit(json_encode(returnData($data, "Cập nhật thành công!")));
    }

    function updateCategory($data)
    {
        global  $db;
        if (empty($data['name']) || empty($data['id'])) {
            exit(json_encode(returnData([], "Vui lòng nhập đầy đủ thông tin!")));
        }

        $check = $db->num_rows("select * from `categories` where `name`='" . trim($data['name']) . "' and `id` <> '" . $data['id'] . "'");
        if ($check != 0) {
            exit(json_encode(ReturnData([], "Danh mục đã tồn tại!"), 400));
        }

        $db->update('categories', ['name' => trim($data['name'])], "`id`='" . $data['id'] . "'");
        exit(json_encode(ReturnData($data, "Cập nhật thành công!"), 200));
    }

    function addCategory($data)
    {
        global $db;
        if (empty($data['name'])) {
            exit(json_encode(ReturnData([], "Tên danh mục không được để trống!"), 400));
        }

        $check = $db->num_rows("select * from `categories` where `name`='" . trim($data['name']) . "'");
        if ($check != 0) {
            exit(json_encode(ReturnData([], "Danh mục đã tồn tại!"), 400));
        }

        $db->insert('categories', ['name' => trim($data['name'])]);
        exit(json_encode(ReturnData($data, "Thêm thành công!"), 200));
    }

    function deleteProduct($data, $table)
    {
        global $db;
        $db->remove($table, "`id`='" . $data['id'] . "'");
        exit(json_encode(ReturnData($data, 'Xóa thành công!')));
    }

    function addProduct($data)
    {
        global $db;

        if (empty($data['idCate']) || empty($data['name']) || empty($data['price']) || empty($data['quantity'])  || empty($data['brand']) || empty($data['desc'])) {
            exit(json_encode(ReturnData([], 'Vui lòng nhập đầy đủ thông tin!')));
        }

        if ($data['price'] <= 0) {
            exit(json_encode(ReturnData([], 'Vui lòng nhập giá tiền!')));
        }

        if ($data['quantity'] <= 0) {
            exit(json_encode(ReturnData([], 'Số lượng tối thiểu là 1!')));
        }

        if (isset($_FILES['image'])) {
            $fileName = $_FILES['image']['name'];
            $fileTmp = $_FILES['image']['tmp_name'];
            $uploadDir =  __DIR__ . '\uploads\\';
            $uploadFile = $uploadDir . basename($fileName);

            if (!move_uploaded_file($fileTmp, $uploadFile)) {
                exit(json_encode(ReturnData([], 'Không thể upload ảnh!')));
            }
        } else {
            exit(json_encode(ReturnData([], 'Chưa có ảnh được chọn!')));
        }

        $db->insert('products', [
            'category_id' => $data['idCate'],
            'name' => $data['name'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'image' => BASE_URL('/ajaxs/admin/uploads/' . basename($fileName)),
            'brand' => $data['brand'],
            'description' => $data['desc']
        ]);
        exit(json_encode(ReturnData($data, 'Thêm mới thành công!')));
    }

    function updateProduct($data)
    {
        global $db;

        if (empty($data['id']) || empty($data['idCate']) || empty($data['name']) || empty($data['price']) || empty($data['quantity'])  || empty($data['brand']) || empty($data['desc'])) {
            exit(json_encode(ReturnData([], 'Vui lòng nhập đầy đủ thông tin!')));
        }

        if ($data['price'] <= 0) {
            exit(json_encode(ReturnData([], 'Vui lòng nhập giá tiền!')));
        }

        if ($data['quantity'] <= 0) {
            exit(json_encode(ReturnData([], 'Số lượng tối thiểu là 1!')));
        }

        $check = $db->num_rows("SELECT * FROM products where `name`='" . $data['name'] . "' and `id` <> '" . $data['id'] . "'");
        if ($check != 0) {
            exit(json_encode(ReturnData([], "Sản phẩm đã tồn tại!"), 400));
        }


        if (isset($_FILES['image'])) {
            $fileName = $_FILES['image']['name'];
            $fileTmp = $_FILES['image']['tmp_name'];
            $uploadDir =  __DIR__ . '\uploads\\';
            $uploadFile = $uploadDir . basename($fileName);

            if (!move_uploaded_file($fileTmp, $uploadFile)) {
                exit(json_encode(ReturnData([], 'Không thể upload ảnh!')));
            }
            $image = true;

            $db->update('products', [
                'image' => BASE_URL('/ajaxs/admin/uploads/' . basename($fileName)),
            ], "`id`='" . $data['id'] . "'");
        }

        $db->update('products', [
            'category_id' => $data['idCate'],
            'name' => $data['name'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'brand' => $data['brand'],
            'description' => $data['desc']
        ], "`id`='" . $data['id'] . "'");
        exit(json_encode(ReturnData($data, 'Cập nhật thành công!')));
    }

    function updateUser($data)
    {
        global $db;
        if (empty($data['id']) || empty($data['user'])) {
            exit(json_encode(ReturnData([], 'Vui lòng điền đầy đủ thông tin!')));
        }

        if (!empty($data['email']) && !CheckData($data['email'], 'email')) {
            exit(json_encode(ReturnData([], 'Sai định dạng email!')));
        }

        if (!empty($data['phone']) && !CheckData($data['phone'], 'phone')) {
            exit(json_encode(ReturnData([], 'Số điện thoại không hợp lệ!')));
        }

        $db->update('users', ['email' => $data['email'], 'phone' => $data['phone'], 'name' => $data['name'], 'active' => $data['active']], "`id`='" . $data['id'] . "'");
        exit(json_encode(ReturnData($data, 'Cập nhật thành công!')));
    }

    switch ($_GET['submit']) {
        case "update":
            update($_POST);
        case "updateCategory":
            updateCategory($_POST);
        case "addCategory":
            addCategory($_POST);
        case "deleteCategory":
            deleteProduct($_POST, 'categories');
        case "deleteProduct":
            deleteProduct($_POST, 'products');
        case "addProduct":
            addProduct($_POST);
        case "updateProduct":
            updateProduct($_POST);
        case "updateUser":
            updateUser($_POST);
    }
}
