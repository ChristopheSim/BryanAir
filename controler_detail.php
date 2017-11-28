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

if($_POST["destination"] == "null")
{
    header('Location: ./reservation');
    exit();
}

$tags = array("title" => "Detail");

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = Sprintf( "SELECT seats, number FROM flights WHERE departure ='CRL' && arrival = '%s' ", $_POST["destination"]);
$result = mysqli_query($conn, $sql);
$flight;

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $flight = $row;
    }
} else {
    echo "0 results";
}

$sql = sprintf("SELECT COUNT(ID) AS taken_seats FROM reservation WHERE flight = '%s'", $flight["number"]);
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $av_seats = $flight["seats"] - $row["taken_seats"];
    }
} else {
    echo "0 results";
}

mysqli_close($conn);

if ($av_seats >= $_POST["NumberOfPassengers"])
{
    $_SESSION["reservation"] = array("total_passenger" => $_POST["NumberOfPassengers"], "registerd_passenger" => 0, "destination" => $_POST["destination"]);
    $_SESSION["flight"] = $flight["number"];
    echo buildHTML("detail", $tags);
}
else
{
    $tags["leftSeat"] = $av_seats;
    echo buildHTML("noSeat" , $tags);
}
?>