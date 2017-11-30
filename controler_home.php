<?php




if(isset($_SESSION["Destination"]))
{

    echo "t'es près pour te tirrer a ".$_SESSION["Destination"]."?";
    
}

session_unset();
$tags = array("title" => "Home");
$_SESSION["status"] = 0;
echo buildHTML("home",$tags);

?>
