<?php

if(empty($_SESSION["status"]) || $_SESSION["status"] != 1)
{
    header('Location: ./');
    exit();
}

if(empty($_POST["arrival"]))
{
    echo "arrival not set or not string";
    exit();
}

if(empty($_POST["departure"]))
{
    echo "departire not set";
    exit();
}

if(empty($_POST["passengers_nb"]) || !ctype_digit($_POST["passengers_nb"]))
{
    echo "passengers_nb not set or not int";
    exit();
}

if(empty($_POST["email"]))
{
    echo "email not set";
    exit();
}

$tags = array("title" => "Detail");

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// get outbound flight data
$obFlight = loadFlightSeatsNumber($conn, $_POST["departure"], $_POST["arrival"]);
$av_seats= getAvailableSeats($conn, $obFlight);

// get return flight data
if(isset($_POST["return"]) == "true")
{
   $rFlight = loadFlightSeatsNumber($conn, $_POST["arrival"], $_POST["departure"]);
   $av_seats_return = getAvailableSeats($conn, $rFlight);
}

mysqli_close($conn);

$reservation = new Reservation($_POST["passengers_nb"], 0, $_POST["email"], $obFlight, $rFlight);


if($av_seats < $reservation->getTotalPassenger())
{
    $tags["leftSeat"] = $av_seats;
    echo buildHTML("noSeat" , $tags);
    exit();
}

if($av_seats_return < $reservation->getTotalPassenger())
{
    $tags["leftSeat"] = $av_seats_return;
    echo buildHTML("noSeat" , $tags);
    exit();
}

$_SESSION["reservation"] = serialize($reservation);
echo buildHTML("detail", $tags);
$_SESSION["status"] = 2;

?>