<?php

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
if (!empty($_SESSION['error']))
    $tags["error"] = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $_SESSION['error'] . '</div>';
$_SESSION["status"] = 1;
echo buildHTML("reservation", $tags);
?>