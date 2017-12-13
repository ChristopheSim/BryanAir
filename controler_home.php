<?php

session_unset();
$tags = array("title" => "Home");
$_SESSION["status"] = 0;
echo buildHTML("home",$tags);

?>
