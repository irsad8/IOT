<?php
include "config.php";

$sql = $conn->query("SELECT * FROM kontroll WHERE id=1");
$row = $sql->fetch_array();

$relay = $row['relay'];
$servo = $row['servo'];

if ($_GET['trol'] == "relay") {
    echo $relay;
} else if ($_GET['trol'] == "servo") {
    echo $servo;
} else {
    return;
}
?>