<?php

if(empty($_POST["first_name"]))
{

    throw new Exception("first name not set");
}

if(empty($_POST["last_name"]))
{
    throw new Exception("last name not set");
}

if(empty($_POST["age"]) || !ctype_digit($_POST["age"]))
{
    throw new Exception("age not set or not int");
}

if(empty($_POST["email"]))
{
    throw new Exception("email not set");
}

if(empty($_POST["id"]))
{
    throw new Exception("id not set");
}

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$insurance = 0;
if(strtolower($_POST['insurance']) == "yes")
{
    $insurance = 1;
}

echo $insurance;
$sql = sprintf("UPDATE clients SET last_name='%s', first_name='%s', age='%s', email='%s' WHERE id='%s' ;",$_POST["last_name"],$_POST["first_name"],$_POST["age"], $_POST["email"],$_POST["id"]);

if (!mysqli_query($conn, $sql)) 
{
    throw new Exception ("Couldn't update passenger"); 
}
mysqli_close($conn);

header("Location: ./admin");


?>