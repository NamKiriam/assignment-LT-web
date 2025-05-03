<?php
session_start();
session_unset();
session_destroy();
header("Location: ../Trang_chu/home.php");
exit();
?>
