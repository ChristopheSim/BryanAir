<?php
switch($_POST["status"])
{
    case 0;
        break;
    case 1;
        header("Location: ./");
        exit();
        break;
}

if($_POST["arrival"] == "null")
{
    header('Location: ./reservation');
    exit();
}

if($_SESSION["status"] != 1)
{
    header('Location: ./');
    exit();
}

$tags = array("title" => "Detail");

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = Sprintf( "SELECT seats, number FROM flights WHERE departure ='%s' && arrival = '%s' ", $_POST["departure"], $_POST["arrival"]);
$result = mysqli_query($conn, $sql);
$flight;

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    $flight = mysqli_fetch_assoc($result);
} 
else {
    echo "0 results";
    exit();
}

$return_flight["number"] = null;
if(isset($_POST["return"]) &&  $_POST["return"] == "true")
{
    $sql = Sprintf( "SELECT seats, number FROM flights WHERE departure ='%s' && arrival = '%s' ", $_POST["arrival"], $_POST["departure"]);
    $result = mysqli_query($conn, $sql);
    $flight;
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        $return_flight = mysqli_fetch_assoc($result);
    } 
    else {
        echo "0 results";
        exit();
    }
}


$sql = sprintf("SELECT COUNT(ID) AS taken_seats FROM reservation WHERE flight = '%s'", $flight["number"]);
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) 
{
    $av_seats = $flight["seats"] - mysqli_fetch_assoc($result)["taken_seats"];
} 
else 
{
    echo "0 results";
    exit();
}

mysqli_close($conn);

if ($av_seats >= $_POST["NumberOfPassengers"])
{
    $_SESSION["reservation"] = array("total_passenger" => $_POST["NumberOfPassengers"], "registerd_passenger" => 0, "arrival" => $_POST["arrival"]);
    $_SESSION["flight"] = $flight["number"];
    $_SESSION["return"] = $return_flight["number"];
    echo buildHTML("detail", $tags);
    $_SESSION["status"] = 2;
}
else
{
    $tags["leftSeat"] = $av_seats;
    echo buildHTML("noSeat" , $tags);
}
?>