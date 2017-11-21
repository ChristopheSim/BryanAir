<?php
$clients = array();
switch($_POST["status"])
{
    case 0;
        break;
    case 1;
        header("Location: ./reservation");
        exit();
        break;
    case 2;
        header("Location: ./");
        exit();
        break;
}

if (isset($_SESSION["clients"]))
{
    $clients = unserialize($_SESSION["clients"]);
}


if($_POST["first_name"] == "" || $_POST["last_name"] == "")
{
    $tags = array("title" => "Detail");
    echo buildHTML("detail", $tags);
    exit();
}

array_push($clients, new Client($_POST["first_name"], $_POST["last_name"],$_POST["age"]));
$_SESSION["clients"] = serialize($clients);
$_SESSION["reservation"]["registerd_passenger"]++; 

if($_SESSION["reservation"]["registerd_passenger"] >= $_SESSION["reservation"]["total_passenger"]) 
{
    echo buildHTML("confirmation");
}
else
{
    $tags = array("title" => "Detail");
    echo buildHTML("detail", $tags);
}
?>