<?php
define('DB_USERNAME', "u931836551_user"); // db user
define('DB_PASSWORD', "123456"); // db password (mention your db password here)
define('DB_SERVER', "185.28.20.4"); // db server
define('DB_DATABASE', "u931836551_place"); // database name
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if (!$connection) {
    die('Could not connect: ' . mysqli_error($connection));
}