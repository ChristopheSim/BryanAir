<?php
$clients = array();

if(empty($_SESSION["status"]) || $_SESSION["status"] != 2)
{
    header('Location: ./');
    exit();
}

if(empty($_POST["first_name"]))
{
    echo "first_name not set";
    exit();
}

if(empty($_POST["last_name"]))
{
    echo "last_name not set";
    exit();
}

if(empty($_POST["age"]) || !ctype_digit($_POST["age"]))
{
    echo "age not set or not int";
    exit();
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
    $_SESSION["status"] = 3;
}
else
{
    $tags = array("title" => "Detail");
    echo buildHTML("detail", $tags);
}
?>