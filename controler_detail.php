<?php
$flight = unserialize($_SESSION["flights"])[$_POST["destination"]];
$tags = array("title" => "Detail");

if ($flight->getAvailableSeat() >= $_POST["NumberOfPassengers"])
{
    $clients = array();
    $_SESSION["clients"] = serialize($clients); 
    $_SESSION["reservation"] = array("total_passenger" => $_POST["NumberOfPassengers"], "registerd_passenger" => 0);

    echo buildHTML("detail", $tags);
}
else
{
    $tags["leftSeat"] = $flight->getAvailableSeat();
    echo buildHTML("noSeat" , $tags);
}
?>