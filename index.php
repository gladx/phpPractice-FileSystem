<?php
include "FileSystem.php";
include "Config.php";

$dir = '.';
if(isset($_GET['dir']))
    $dir = $_GET['dir'];
$fs = new FileSystem($dir);
$fs->showList();
