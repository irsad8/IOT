<?php 
include "config.php";

if (isset($_GET['stat'])) {
    $stat = $_GET['stat'];
    if ($stat == "ON") {
        $conn->query("UPDATE kontrol SET relay=1 WHERE id=1");
        echo "ON";
    } else {
        $conn->query("UPDATE kontrol SET relay=0 WHERE id=1");
        echo "OFF";
    }
} else if (isset($_GET['sud'])) {
    $sud = $_GET['sud'];
    $conn->query("UPDATE kontrol SET servo='$sud' WHERE id=1");
    echo $sud;
} else{
    header("Location: index.php");
    exit;
}


?>