<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_GET) && !empty($_GET['submit'])) {
    $data = json_decode(file_get_contents("php://input"), true);
    if (is_array($data)) {
        $_POST = xss_array($data);
    }

    function store($data)
    {
        global $db;
        if (empty($data['id']) || empty($data['userId']) || empty($data['phone']) || empty($data['address']) || empty($data['startDate']) || empty($data['endDate'])) {
            exit(json_encode(returnData([], "Vui lòng điền đầy đủ thông tin!")));
        }

        if (!CheckData($data['phone'], 'phone')) {
            exit(json_encode(returnData([], "Số điện thoại không hợp lệ!")));
        }

        // tính số ngày đặt
        $startDate = strtotime($data['startDate']);
        $endDate = strtotime($data['endDate']);

        $diff = ($endDate - $startDate) / (60 * 60 * 24);

        $product = $db->fetch_assoc("SELECT * from `products` where `id`='" . $data['id'] . "'", 1);

        if ($product['quantity'] == 0) {
            exit(json_encode(returnData([], "Hết hàng!")));
        }

        $db->insert('rental_requests', [
            'product_id' => $data['id'],
            'user_id' => $data['userId'],
            'address' => $data['phone'] . ' - ' . $data['address'],
            'start_date' => $data['startDate'],
            'end_date' => $data['endDate'],
            'status1' => 'pending',
            'status2' => 'notpaid',
            'price' => $diff * $product['price']
        ]);

        $db->update('products', ['quantity' => $product['quantity'] - 1], "`id`='" . $data['id'] . "'");

        exit(json_encode(returnData($data, "Đặt thành công!")));
    }


    switch ($_GET['submit']) {
        case "store":
            store($_POST);
    }
}
