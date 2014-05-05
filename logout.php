<?php
session_start();
session_destroy();
unset($users);
header('Location: index.php');
?>
