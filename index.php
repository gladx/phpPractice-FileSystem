<?php
include "FileSystem.php";
include "Config.php";

$dir = '.';
if (isset($_GET['dir'])) {
    $dir = $_GET['dir'];
}
$fs = new FileSystem($dir);

// Command 
$cmd = '';
if (isset($_GET['cmd'])) {
    $cmd = $_GET['cmd'];
}
switch($cmd)
{
    case 'copy' :
        $fs->copy( $_GET['src'],  $_GET['dest']);
    break;
}

$fs->showList();
