<?php
include "FileSystem.php";
include "Config.php";

$dir = '.';
if (isset($_GET['dir'])) {
    $dir = $_GET['dir'];
}
$fs = new FileSystem($dir);

// Command 
if (isset($_GET['cmd'])) {
    $cmd = $_GET['cmd'];

    switch ($cmd) {
        case 'copy':
            $fs->copy($_GET['src'], $_GET['dest']);
            break;
        case 'delete':
            $fs->delete($_GET['src'], @$_GET['confirm']);
            break;
        case 'mkdir':
            $fs->mkdir($_GET['path']);
            break;
        case 'mv':
            $fs->mv($_GET['oldpath'], $_GET['newpath']);
            break;
        default:
            echo 'Faild Command ' . END_LINE;
            break;
    }
}

//LAB 
//print_r($_GET);
$fs->showList();
