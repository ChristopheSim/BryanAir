<?php


// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn)
{
    die("Connection failed: " . mysqli_connect_error());
}

$sql="SELECT number, departure, arrival FROM flights";
$result = mysqli_query($conn, $sql);

$tables = "";
if (mysqli_num_rows($result) > 0)
{
    // output data of each row
    while ($row = mysqli_fetch_assoc($result))
    {
        $tables .= sprintf("<h5>%s  (%s)  -->  (%s)</h5>", $row['number'], $row['departure'], $row['arrival']);
        $sql="SELECT first_name, last_name, age, email, inssurance
        FROM reservation R, clients C
        WHERE R.client = C.ID AND R.flight = " . $row['number'];
        $client_result = mysqli_query($conn, $sql);
        $tables .= '<table class="table">
                    <thead>
                            <tr>
                              <th scope="col">First Name</th>
                              <th scope="col">Last Name</th>
                              <th scope="col">Age</th>
                              <th scope="col">email</th>
                              <th scope="col">Annulation Insurance</th>
                            </tr>
                    </thead>
                    <tbody>';
        if (mysqli_num_rows($client_result) > 0)
        {
            while ($client = mysqli_fetch_assoc($client_result))
            {
                $insurance = "No";
                if($client['inssurance'] == 1)
                {
                    $insurance = "Yes";
                }
                $tables .=  sprintf("<tr>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
            </tr>",$client["first_name"], $client["last_name"], $client["age"], $client["email"], $insurance);   
            }
        }

        $tables .= "</tbody></table>";
    }
}
else
{
    throw new Exception("No match found");
}
$tags["title"] = "Admin";
$tags["tables"] = $tables;

mysqli_close($conn);
echo buildHTML("admin", $tags);
?>