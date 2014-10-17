<?php
session_start();
$error = "";

require_once __DIR__ . '/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['place']) || empty($_POST['password'])) {
        $error = "password is invalid";
    } else {
        $place = mysqli_real_escape_string($connection, $_POST['place']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);

        $sql = "SELECT id,title,news_ua,news_us,news_ru FROM marker WHERE id='$place' and password='$password'";
        $result = mysqli_query($connection, $sql);

        if ($result->num_rows == 1) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $_SESSION['id'] = $place;
            $_SESSION['title'] = $row['title'];
            header("location: place.php");
        } else {
            $error = "password is invalid";
        }
        mysqli_free_result($result);
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>place news login</title>
    <style>

    </style>
</head>
<body>
<div id="border">
    <form action="" method="post">
        <label>your place : </label><?php include 'selection.php'; ?><br>
        <label>password : </label><input name="password" type="password">
        <input type="submit" value="submit"><br>

        <p style="color: red;"><?php echo $error; ?>
    </form>
</div>

</body>
</html>