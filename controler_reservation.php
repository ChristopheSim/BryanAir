<?php

$baraki = new Flight("baraki" , "15/11/2017 09:20","BR987");
$torremolinos = new Flight("Torremolinos" , "15/11/2017 09:20","BR3657");
$_SESSION["flights"] = serialize(array($baraki, $torremolinos));
   
echo buildHTML("reservation");
?>