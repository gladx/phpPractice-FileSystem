<?php
// Define Area
define('ENV_CLI', false);
if(ENV_CLI)
    define('END_LINE', "\n");
else
    define('END_LINE', "<br>");

// Error Config
ini_set('display_errors', 1);