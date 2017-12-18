<?php 

if(empty($_SESSION["status"]) || $_SESSION["status"] != 4)
{
    header('Location: ./');
    exit();
}

$reservation = unserialize($_SESSION["reservation"]);

$table_clients = ""; 
foreach($reservation->getClients() as $client)
{
    $table_clients .= sprintf("<tr>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                        </tr>",$client->getFirstName(), $client->getLastName(), $client->getAge());
}

$inssurance = "No";
if($reservation->getInssurance())
{
    $inssurance = "Yes";
}
$conn = mysqli_connect($servername, $username, $password, $dbname);
$tags["price"] = $reservation->getPrice($conn);  
mysqli_close($conn);
$tags["inssurance"] = $inssurance;
$tags["title"] = "Resumer";
$tags["table_client"] = $table_clients;
echo buildHTML("resumer", $tags); 

$_SESSION["status"] = 5;
?>