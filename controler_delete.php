<?php

if(empty($_POST["id"]))
{
    throw new Exception("id not set");
}
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

print_r($_POST);
// sql to delete a record
$sql = sprintf("DELETE FROM reservation WHERE client=%s",$_POST["id"]);

if (!mysqli_query($conn, $sql)) 
{
    throw new Exception("Couldn't delete passenger");
}

mysqli_close($conn);
header("Location: ./admin");
?>