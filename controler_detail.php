<?php
$flight = array_filter(unserialize($_SESSION["flights"]),function($flight){return $flight -> getDestination() == $_POST["destination"];})[0];

if ($flight->getAvailableSeat() >= $_POST["NumberOfPassengers"])
{
    $clients = array();
    $_SESSION["clients"] = serialize($clients); 
    $_SESSION["reservation"] = array("total_passenger" => $_POST["NumberOfPassengers"], "registerd_passenger" => 0);

    $tags = array("title" => "Detail");
    echo buildHTML("detail", $tags);
}


?>