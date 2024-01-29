<?php
//استدعاء ملف الاتصال بالداتا بيس
include 'connect.php';

//مسارات الملفات
$tpl = 'includes/templates/'; // Template Directory
$lan = 'includes/languages/'; // Language Directory
$func = 'includes/functions/'; // Functions Directory
$css = 'layout/css/'; // Css Directory
$js = 'layout/js/'; // Js Directory
$images = 'layout/images/'; // Js Directory

//include the important files
include $func . 'functions.php';
include $lan . 'ar.php';
include $tpl . 'header.php';

date_default_timezone_set("Africa/Algiers");

if (!isset($noNavbar)) { ?>
    <div class="page home-page">
        <?php
        include $tpl . 'navbar.php';
        ?>
        <div class="content-area">
            <div class="overlay"> </div>
            <div class="container">
                <div class="content">
                <?php
                include $tpl . "page-head.php";
            }
