<?php
require_once(__DIR__ . '/core/.config.php');
if (DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}
$current_page = basename($_SERVER['PHP_SELF']);
if (file_exists(__DIR__ . $path_info . ".php") && !is_dir(__DIR__ . $path_info . ".php")) {

    include __DIR__ . $path_info . ".php";
    exit();
}
if (file_exists(__DIR__ . "/view" . $path_info . ".php")) {
    include __DIR__ . "/view" . $path_info . ".php";
    exit();
}
moveUrl("/client/home");
exit();