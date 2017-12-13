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
$sql = Sprintf( "SELECT seats, number FROM flights WHERE departure ='%s' && arrival = '%s' ", $_POST["departure"], $_POST["arrival"]);
$result = mysqli_query($conn, $sql);
$flight;

if (mysqli_num_rows($result) > 0) {
    
    $flight = mysqli_fetch_assoc($result);
    $obFlight = new Flight($_POST["departure"], $_POST["arrival"], $flight["number"], $flight["seats"]);
    // count number of taken seat for outbound
    $sql = sprintf("SELECT COUNT(ID) AS taken_seats FROM reservation WHERE flight = '%s'", $obFlight->getNumber());
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) 
    {
        $av_seats = $obFlight->getSeats() - mysqli_fetch_assoc($result)["taken_seats"];
    } 
    else 
    {
        $_SESSION['error'] = '0 results';
        header('Location: /reservation');
        die();
    }
} 
else {
    $_SESSION['error'] = '0 results';
    header('Location: /BryanAir/reservation');
    die();
}

//crer une fonction charge flight avec en param un flight

// get return flight data
if(isset($_POST["return"]) == "true")
{
    $sql = Sprintf( "SELECT seats, number FROM flights WHERE departure ='%s' && arrival = '%s' ", $_POST["arrival"], $_POST["departure"]);
    $result = mysqli_query($conn, $sql);
    $flight;
    if (mysqli_num_rows($result) > 0) 
    {
        $return_flight = mysqli_fetch_assoc($result);
        $rFlight = new Flight($_POST["arrival"], $_POST["departure"], $return_flight["number"], $return_flight["seats"]);
        // count number of taken seat for outbound
        $sql = sprintf("SELECT COUNT(ID) AS taken_seats FROM reservation WHERE flight = '%s'", $rFlight->getNumber());
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) 
        {
            $av_seats_return = $rFlight->getSeats() - mysqli_fetch_assoc($result)["taken_seats"];
        } 
        else 
        {
            $_SESSION['error'] = '0 results';
            header('Location: /reservation');
            die();
        }
    } 
    else 
    {
        $_SESSION['error'] = '0 results';
        header('Location: /reservation');
        die();
    }
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