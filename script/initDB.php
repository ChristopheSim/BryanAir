<?php 
include "../utils.php";

//run to init DB: http://localhost/BryanAir/script/initDB.php

$conn = mysqli_connect($servername, $username, $password, $dbname);
$query = file_get_contents("bryanair.sql");

/* execute multi query */
if (mysqli_multi_query($conn, $query))
     echo "Success";
else 
     echo "Fail";

mysqli_close($conn);
?>