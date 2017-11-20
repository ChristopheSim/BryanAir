<?php

$baraki = new Flight("baraki" , "15/11/2017 09:20","BR987");
$torremolinos = new Flight("Torremolinos" , "15/11/2017 09:20","BR3657");
$flights = array($baraki, $torremolinos);
$_SESSION["flights"] = serialize($flights);

$destinationsHTML = "";

foreach($flights as $flight)
{
$destinationsHTML .= "<option>";
$destinationsHTML .= $flight->getDestination();
$destinationsHTML .= "</option>";
}

$tags = array("destinations" => $destinationsHTML);
$tags["title"] = "Reservation";
echo buildHTML("reservation", $tags);
?>