<?php

if(empty($_SESSION["status"]))
{
    header('Location: ./');
    exit();  
}

if($_SESSION["status"] < 3)

{
    if($_SESSION["status"] != 2 )
    {
        header('Location: ./');
        exit();
    }
    
    if(empty($_POST["first_name"]))
    {
    
        throw new Exception("first_name not set");
    }
    
    if(empty($_POST["last_name"]))
    {
        throw new Exception("last_name not set");
    }
    
    if(empty($_POST["age"]) || !ctype_digit($_POST["age"]))
    {
        throw new Exception("age not set or not int");
    }
    
    $reservation = unserialize($_SESSION["reservation"]);
    
    $reservation->addClient(new Client($_POST["first_name"], $_POST["last_name"],$_POST["age"]));
}


if($reservation->getRegisterdPassenger() >= $reservation->getTotalPassenger()) 
{
    echo buildHTML("confirmation", $tags);
    $_SESSION["status"] = 3;
}
else
{
    $_SESSION["status"] = 2;
    $tags ["title"] = "Detail";
    echo buildHTML("detail", $tags);
}
$_SESSION["reservation"] = serialize($reservation);
?>