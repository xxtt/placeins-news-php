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
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="images/favicon.ico">
    <style>

    </style>
</head>
<body class="stars">
 <div id="main">
  <a href="http://placeins.com/">
  <img id="logo" src="images/logo.png" alt="place in space logo" align="middle" >
     </a>
      <br><br>
       <form action="" method="post">
        <label>choose your place : </label><?php include 'selection.php'; ?><br>
        <br>
        <label>password : </label>
        <input id="password" name="password" placeholder="**********" type="password">
        <input name="submit" type="submit" value=" Login ">
        <p style="color: red;"><?php echo $error; ?>
    </form>
</div>
    
</body>
</html>