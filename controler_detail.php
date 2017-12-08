<?php

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

if($_SESSION["status"] != 1)
{
    header('Location: ./');
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

    // count number of taken seat for outbound
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
} 
else {
    echo "0 results";
    exit();
}

// get return flight data
$return_flight["number"] = null;
if(isset($_POST["return"]) == "true")
{
    $sql = Sprintf( "SELECT seats, number FROM flights WHERE departure ='%s' && arrival = '%s' ", $_POST["arrival"], $_POST["departure"]);
    $result = mysqli_query($conn, $sql);
    $flight;
    if (mysqli_num_rows($result) > 0) 
    {
        $return_flight = mysqli_fetch_assoc($result);
        // count number of taken seat for outbound
        $sql = sprintf("SELECT COUNT(ID) AS taken_seats FROM reservation WHERE flight = '%s'", $flight["number"]);
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) 
        {
            $av_seats_return = $flight["seats"] - mysqli_fetch_assoc($result)["taken_seats"];
        } 
        else 
        {
            echo "0 results";
            exit();
        }
    } 
    else 
    {
        echo "0 results";
        exit();
    }
}

mysqli_close($conn);

if($av_seats < $_POST["passengers_nb"])
{
    $tags["leftSeat"] = $av_seats;
    echo buildHTML("noSeat" , $tags);
    exit();
}

if($av_seats < $_POST["passengers_nb"])
{
    $tags["leftSeat"] = $av_seats;
    echo buildHTML("noSeat" , $tags);
    exit();
}

$_SESSION["reservation"] = array("total_passenger" => $_POST["passengers_nb"], "registerd_passenger" => 0, "arrival" => $_POST["arrival"]);
$_SESSION["flight"] = $flight["number"];
$_SESSION["return"] = $return_flight["number"];
$_SESSION["email"] = $_POST["email"];
echo buildHTML("detail", $tags);
$_SESSION["status"] = 2;

?>