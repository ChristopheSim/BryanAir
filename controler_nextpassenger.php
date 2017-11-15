<?php

$clients = unserialize($_SESSION["clients"]);
array_push($clients, new Client($_POST["first_name"], $_POST["last_name"],$_POST["age"]));
$_SESSION["clients"] = serialize($clients);
$_SESSION["reservation"]["registerd_passenger"]++; 

if($_SESSION["reservation"]["registerd_passenger"] >= $_SESSION["reservation"]["total_passenger"]) 
{

    echo buildHTML("home");
}
else
{
    echo buildHTML("detail");
}
?>