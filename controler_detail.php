<?php
$flight = unserialize($_SESSION["flights"])[$_POST["destination"]];
print_r($flight);

if ($flight->getAvailableSeat() >= $_POST["NumberOfPassengers"])
{
    $clients = array();
    $_SESSION["clients"] = serialize($clients); 
    $_SESSION["reservation"] = array("total_passenger" => $_POST["NumberOfPassengers"], "registerd_passenger" => 0);

    $tags = array("title" => "Detail");
    echo buildHTML("detail", $tags);
}
?>