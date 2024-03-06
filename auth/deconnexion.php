<?php

session_start();

$_SESSION = array();

session_destroy();

header("location: /MixMart/pages/accueil.php");

exit();

?>
