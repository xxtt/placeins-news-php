<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("location: index.php");
}

$password = "";
$message = "";
require_once __DIR__ . '/config.php';
$id = mysqli_real_escape_string($connection, $_SESSION['id']);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT news_ua,news_us,news_ru FROM marker WHERE id='$id'";
    $result = mysqli_query($connection, $sql);

    if ($result->num_rows == 1) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $text_ua = $row["news_ua"];
        $text_us = $row["news_us"];
        $text_ru = $row["news_ru"];
        mysqli_free_result($result);
    } else {
        $message = "database error:" . mysqli_error($connection);
    }
} else {
    $text_ua = $_POST["text_ua"];
    $text_us = $_POST["text_us"];
    $text_ru = $_POST["text_ru"];
}

if (isset($_POST['change'])) {
    if (empty($_POST["password"])) {
        $password = "password can't be empty";
    } else {
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        $sql = "UPDATE marker SET password='$password' WHERE id='$id'";

        if (mysqli_query($connection, $sql)) {
            $password = "password has been changed to " . $password;
        } else {
            $password = "database update error:" . mysqli_error($connection);
        }
    }
}
if (isset($_POST["save"])) {
    $message = "can't save, some language is empty :( ";
    if ((!empty($text_ua)) && (!empty($text_us)) && (!empty($text_ru))) {
        $sql = "UPDATE marker SET news_ua='$text_ua',news_us='$text_us',news_ru='$text_ru' WHERE id='$id'";

        if (mysqli_query($connection, $sql)) {
            $message = "news has been saved";
        } else {
            $message = "database update error:" . mysqli_error($connection);
        }
    }
}

if (isset($_POST['delete'])) {
    $message = "news has been deleted";
    if ((!empty($text_ua)) || (!empty($text_us)) || (!empty($text_ru))) {
        $text_ua = null;
        $text_us = null;
        $text_ru = null;
        $sql = "UPDATE marker SET news_ua='$text_ua',news_us='$text_us',news_ru='$text_ru' WHERE id='$id'";

        if (!mysqli_query($connection, $sql)) {
            $message = "database update error:" . mysqli_error($connection);
        }
    }
}
mysqli_close($connection);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>place news</title>
     <link href="css/style.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="images/favicon.ico">
</head>
<body class="stars">
  <a href="http://placeins.com/">
  <img id="logo" src="images/logo.png" alt="place in space logo" align="middle">
  </a>
  <br><br>
<label>welcome to <?php echo $_SESSION['title'] ?> news</label>
<br><br>
<form action="" method="post">
    <label>new password:</label> <input type="text" name="password" maxlength="20">
    <input type="submit" name="change" value="change">

    <p style="color: green;"><?php echo $password; ?></p>

    <label>edit your news in russian:</label><br><br>
    <textarea style="width: 300px;height:200px;" name="text_ru" maxlength="200"><?php echo $text_ru ?></textarea>
    <label>ukrainian:</label>
    <textarea style="width: 300px;height:200px;" name="text_ua" maxlength="200"><?php echo $text_ua ?></textarea>
    <label>english:</label>
    <textarea style="width: 300px;height:200px;" name="text_us" maxlength="200"><?php echo $text_us ?></textarea>
    <input type="submit" name="save" value="save">
    <input type="submit" name="delete" value="delete">

    <p style="color: mediumvioletred;"><?php echo $message; ?>
</form>
<form action="logout.php" method="get">
    <input type="submit" value="log out">
</form>

</body>
</html>