<?php

require_once("utils.php");
require_once("Flight.php");
require_once("Client.php");

session_start();

//router
if (!empty($_GET['page']))
{   
    $controler_file = 'controler_'.$_GET['page'].'.php';
    if (file_exists($controler_file))
    {
        include $controler_file;
    }
    else
    {
        include 'controler_404.php';
    }
    
}
else
{
    $baraki = new Flight("baraki" , "15/11/2017 09:20","BR987");
    $torremolinos = new Flight("Torremolinos" , "15/11/2017 09:20","BR3657");
    $flights = array($baraki, $torremolinos);
    $_SESSION["flights"] = serialize($flights);
    include 'controler_home.php';
}

?>