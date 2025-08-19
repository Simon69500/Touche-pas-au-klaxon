<?php
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

var_dump(getenv('DB_HOST'));
var_dump(getenv('DB_NAME'));
var_dump(getenv('DB_USER'));
var_dump(getenv('DB_PASS'));
