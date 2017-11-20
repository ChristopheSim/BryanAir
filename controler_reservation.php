<?php

$flights = unserialize($_SESSION["flights"]);


$destinationsHTML = "";
$i = 0;
foreach($flights as $flight)
{
$destinationsHTML .= sprintf("<option value= %d>", $i);
$destinationsHTML .= $flight->getDestination();
$destinationsHTML .= "</option>";
$i++;
}

$tags = array("destinations" => $destinationsHTML);
$tags["title"] = "Reservation";
echo buildHTML("reservation", $tags);
?>