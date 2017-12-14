<?php
//DB indentifier
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "BryanAir";

function buildHTML($page_body, $tags = null)
{
    $body = <<<EOS
    <!DOCTYPE html>
    <html>
EOS;

    $body .= file_get_contents ("templates/head.html");

    $body .= "<body>";

    $body .= file_get_contents ("templates/header.html");
    $body .= file_get_contents (sprintf("templates/%s.html", $page_body));
    $body .= file_get_contents ("templates/footer.html");

    $body .= <<<EOS
        </body>
    </html>
EOS;

    if($tags == null) 
    {
        return $body;
    }
    else
    {
        return replaceTags(buildHTML($page_body),$tags);
    }
}



function replaceTags($content, $tags)
{
  
    $pattern = array_map(function($pat){
        return '/\$' . $pat . '\$/';
    },array_keys($tags));     
    $content = preg_replace($pattern, $tags, $content);
    return  $content;
}

function loadFlightSeatsNumber($conn, $dep, $arr)
{
    $sql = "SELECT seats, number FROM flights WHERE departure = '$dep' && arrival = '$arr' ";
    $result = mysqli_query($conn, $sql);
    $flight;
    if (mysqli_num_rows($result) > 0) 
    {
        $flight = mysqli_fetch_assoc($result);
        $output_flight = new Flight($_POST["arrival"], $_POST["departure"], $flight["number"], $flight["seats"]);
    } 
    else 
    {
        $_SESSION['error'] = '0 results';
        header('Location: BryanAir/reservation');
        die();
    }
    return $output_flight;
}

function getAvailableSeats($conn, $flight)
{
    $sql = sprintf("SELECT COUNT(client) AS taken_seats FROM reservation WHERE flight = '%s'", $flight->getNumber());
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) 
    {
        $av_seats = $flight->getSeats() - mysqli_fetch_assoc($result)["taken_seats"];
    } 
    else 
    {
        $_SESSION['error'] = '0 results'; 
        header('Location: BryanAir/reservation');
        die();
    }
    return $av_seats;
}
?>
