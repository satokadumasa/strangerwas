<?php
#$autoloader = require "vendor/autoload.php";
#echo json_encode($autoloader->getPrefixesPsr4(), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
$autoloader = require "vendor/autoload.php";
$result = $autoloader->findFile('strangerfw\core\Route');
echo json_encode($result);
exit;

