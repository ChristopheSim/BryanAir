<?php

session_unset();
$tags["title"] = "Home";
$_SESSION["status"] = 0;
echo buildHTML("home",$tags);

?>
