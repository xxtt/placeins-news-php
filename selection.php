<?php

$sql = "SELECT id,title FROM marker";
$result = mysqli_query($connection, $sql);

if ($result->num_rows > 0) {
    echo "<select name='place'>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<option value='" . $row['id'] . "'>" . $row['title'] . "</option>";
    }
    echo "</select>";
} else {
    echo "Database error !!";
}
mysqli_free_result($result);
mysqli_close($connection);