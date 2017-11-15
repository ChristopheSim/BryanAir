<?php


$flight = unserialize($_SESSION["flights"])[0];

if ($flight->getAvailableSeat() >= $_POST["NumberOfPassengers"])
{
    $clients = array();
    $_SESSION["clients"] = serialize($clients); 
    $_SESSION["reservation"] = array("total_passenger" => $_POST["NumberOfPassengers"], "registerd_passenger" => 0);
    echo buildHTML("detail");
}


?>