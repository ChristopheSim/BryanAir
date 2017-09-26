<?php
session_start();

//router
if (!empty($_GET['page']) && is_file('controler_'.$_GET['page'].'.php'))
{    
    include 'controler_'.$_GET['page'].'.php';
}
else
{    
    include 'controler_home.php';
}

?>