<?php
include "utils.php";



if(isset($_SESSION["Destination"]))
{

    echo "t'es près pour te tirrer a ".$_SESSION["Destination"]."?";
    
}
echo buildHTML("home");


?>
