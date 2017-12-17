<?php

if(empty($_SESSION["status"]))
{
    header('Location: ./');
    exit();
}
if($_SESSION["status"] < 2)
{
    if($_SESSION["status"] != 1)
    {
        header('Location: ./');
        exit();
    }
    
    if(empty($_POST["arrival"]))
    {
        throw new Exception("arrival not set or not string");
    }
    
    if(empty($_POST["departure"]))
    {
        throw new Exception("departure not set");
    }
    
    if(empty($_POST["passengers_nb"]) || !ctype_digit($_POST["passengers_nb"]))
    {
        throw new Exception("passengers_nb not set or not int");
    }
    
    if(empty($_POST["email"]))
    {
        throw new Exception("email not set");
    }
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    if (!$conn) {
        throw new Exception("Could not connect to DB");
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
    
    
    if($av_seats < $reservation->getTotalPassenger() || $av_seats_return < $reservation->getTotalPassenger())
    {
        throw new Exception("There is no more seats for this flight");
    }
    $_SESSION["reservation"] = serialize($reservation);
}

$tags["title"] = "Detail";
echo buildHTML("detail", $tags);
$_SESSION["status"] = 2;

?>