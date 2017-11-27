<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "BryanAir";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$sql = "SELECT IATA, name FROM airport";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {

    $destinationsHTML = "";
    while($airport = mysqli_fetch_assoc($result)) {
        $destinationsHTML .= sprintf("<option value= %s>", $airport["IATA"]);
        $destinationsHTML .= sprintf("%s - (%s)", $airport["name"], $airport["IATA"]);
        $destinationsHTML .= "</option>";
    }
} else {
    echo "0 results";
}

mysqli_close($conn);

$tags = array("destinations" => $destinationsHTML);
$tags["title"] = "Reservation";

echo buildHTML("reservation", $tags);
?>