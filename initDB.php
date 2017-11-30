<?php 
include "utils.php"
$query = file_get_contents("bryanair.sql");

/* execute multi query */
if (mysqli_multi_query($conn, $query))
     echo "Success";
else 
     echo "Fail";
?>