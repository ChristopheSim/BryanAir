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
    include 'controler_home.php';
}

?>