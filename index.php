<?php

require_once("utils.php");
require_once("models/Flight.php");
require_once("models/Client.php");
require_once("models/Reservation.php");

session_start();
$tags = array("error" => "");
//router

if (!empty($_GET['page']))
{   
    $controler_file = 'controler_'.$_GET['page'].'.php';
    
    if (file_exists($controler_file))
    {
        try
        {
            include $controler_file;
            $_SESSION["lastControler"]= $controler_file;
        }
        catch(Exception $e)
        {
            $tags["error"] = '<div class="container"><div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $e->getMessage() . '</div></div>';
            include $_SESSION["lastControler"];
        }
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