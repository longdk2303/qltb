<?php
function website($setting_key)
{
    global $db;
    return $db->fetch_assoc("SELECT * FROM `website` WHERE `name` = '$setting_key'", 1)['value'];
}

function calTime($created_at)
{
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    $diff_seconds = abs(strtotime(date("Y-m-d H:i:s", time())) - strtotime($created_at));
    $diff_minutes = floor($diff_seconds / 60);
    $diff_hours = floor($diff_minutes / 60);
    $diff_days = floor($diff_hours / 24);

    $time = '';
    if ($diff_days > 0) {
        $time = $diff_days . ' ngày trước';
    } elseif ($diff_hours > 0) {
        $time = $diff_hours . ' giờ trước';
    } else {
        $time = $diff_minutes . ' phút trước';
    }
    return $time;
}

function textStatus($status)
{
    switch ($status) {
        case 'pending':
            return "<div class='text-danger'>Đang xử lý</div>";
        case 'success':
            return "<div class='text-success'>Thành Công</div>";
        case 'refuse':
            return "<div class='text-danger'>Hủy</div>";
        case 'paid':
            return "<div class='text-success'>Đã trả</div>";
        case 'notpaid':
            return "<div class='text-danger'>Chưa trả</div>";
        case 'expired':
            return "<div class='text-info'>Quá hạn</div>";
        case 'active':
            return "<div class='text-success'>Hoạt động</div>";
        case 'ban':
            return "<div class='text-danger'>Đang khóa</div>";
    }
}

function myip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip_address = $_SERVER['REMOTE_ADDR'];
    }
    return $ip_address;
}

// Phần Xác Thực Chuẩn Quy Tắc
function CheckData($data, $type)
{
    $return = false;
    switch ($type) {
        case "email":
            if (filter_var($data, FILTER_VALIDATE_EMAIL)) {
                $return = true;
            }
            break;

        case "phone":
            // Kiểm tra số điện thoại với + hoặc không có + ở đầu, và chứa ít nhất 3 số
            if (preg_match('/^\+?(\d.*){3,}$/', $data)) {
                $return = true;
            }
            break;

        case "username":
            if (preg_match('/^[a-zA-Z0-9_-]{3,16}$/', $data, $matches)) {
                $return = true;
            }
            break;

        case "password":
            if (strlen($data) < 6) {
                return false;
            }
            $pattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^a-zA-Z\d]).+$/';
            if (preg_match($pattern, $data)) {
                $return = true;
            }
            break;
        case "string":
            if (trim(htmlspecialchars(addslashes($data)))) {
                $return = true;
            }
            break;

        case "url":
            if (filter_var($data, FILTER_VALIDATE_URL)) {
                $return = true;
            }
            break;

        case "ip":
            // Kiểm tra địa chỉ IP (IPv4 hoặc IPv6)
            if (filter_var($data, FILTER_VALIDATE_IP)) {
                $return = true;
            }
            break;

        case "int":
            if (filter_var($data, FILTER_VALIDATE_INT)) {
                $return = true;
            }
            break;

        case "float":
            if (filter_var($data, FILTER_VALIDATE_FLOAT)) {
                $return = true;
            }
            break;

        case "boolean":
            if (is_bool(filter_var($data, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE))) {
                $return = true;
            }
            break;

        case "alpha":
            // Chỉ chứa chữ cái
            if (ctype_alpha($data)) {
                $return = true;
            }
            break;

        case "alnum":
            // Chỉ chứa chữ cái và số
            if (ctype_alnum($data)) {
                $return = true;
            }
            break;

        case "slug":
            // Kiểm tra chuỗi dạng slug (chỉ chứa chữ cái, số, dấu gạch ngang)
            if (preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $data)) {
                $return = true;
            }
            break;
        default:
            break;
    }
    return $return;
}

function BASE_URL($url)
{
    return DOMAINS . $url;
}
function moveUrl($path)
{
    header("Location: " . DOMAINS . "{$path}");
}

// Trả về data array
function ReturnData($data, $message = null)
{
    if (!empty($data)) {
        return [
            'message'   => $message ?? "Thành Công",
            'error'     => 0,
            'data'      => $data
        ];
    } else {
        return [
            'message'   => $message ?? "Thất Bại",
            'error'     => 1,
            'data'      => []
        ];
    }
}

// Get current date and time
function Dtime($days = 0, $months = 0, $years = 0)
{
    $currentDate = new DateTime();
    if ($days !== 0) {
        $currentDate->modify("+{$days} days");
    }
    if ($months !== 0) {
        $currentDate->modify("+{$months} months");
    }
    if ($years !== 0) {
        $currentDate->modify("+{$years} years");
    }
    return $currentDate->format('Y-m-d H:i:s');
}

// Sanitize input to prevent XSS attacks
function xss($data)
{
    $data = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);
    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
    $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
    $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
    do {
        $old_data = $data;
        $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
    } while ($old_data !== $data);
    return htmlspecialchars(addslashes(trim($data)));
}

// Bảo Mật Chống Attack
function xss_array($data)
{
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = xss_array($value);
        }
    } else {
        $data = xss($data);
    }
    return $data;
}
