<?php
//Cấu Hình Cơ Sở Dữ Liệu
define('APP_NAME', 'QUẢN LÝ THIẾT BỊ');
define('DOMAINS', 'http://localhost/qltb'); //Url Tới Trang Chính của WEBSITE VD: http://localhost/{path nếu có}

// Cơ Cấu SQL
define('DB_CONNECTION', 'mysql');
define('DB_HOST', 'localhost');
define('DB_DATABASE', 'thuesp');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

define('DEBUG', 'true');

// PATH
$path_info = $_SERVER['PATH_INFO'] ?? '/';

//Root
if (isset($_SERVER['HTTP_HOST']) && isset($_SERVER['REQUEST_URI'])) {
    define("URL_ROOT", $_SERVER['HTTP_HOST'] . "/" . $_SERVER['REQUEST_URI']);
} else {
    define("URL_ROOT", "default_value");
}

require_once(__DIR__ . '/database.php');
require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/session.php');

$db->update('rental_requests', ['status2' => 'expired'], 'end_date < CURDATE()');
$db->update('rental_requests', ['status1' => 'refuse'], "status2 = 'expired' and status1 = 'pending'");

if (!empty($session->get('account'))) {
    $User_data = $db->fetch_assoc("SELECT rl.role_name, u.* FROM users AS u JOIN roles AS rl ON u.role_id = rl.id WHERE u.`id` = '" . $session->get('account') . "'", 1);
    if (empty($User_data)) {
        $session->destroy();
    }
}
