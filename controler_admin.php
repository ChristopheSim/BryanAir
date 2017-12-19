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
        $tables .= sprintf("<h5>%s  (%s)  <i class='fa fa-long-arrow-right' aria-hidden='true'></i>  (%s)</h5>", $row['number'], $row['departure'], $row['arrival']);
        $sql="SELECT first_name, last_name, age, email, inssurance, C.ID
        FROM reservation R, clients C
        WHERE R.client = C.ID AND R.flight = " . $row['number'];
        $client_result = mysqli_query($conn, $sql);
        $tables .= '<table class="table text-white">
                    <thead>
                            <tr>
                              <th scope="col">First Name</th>
                              <th scope="col">Last Name</th>
                              <th scope="col">Age</th>
                              <th scope="col">email</th>
                              <th scope="col">Annulation Insurance</th>
                              <th scope="col"></td>
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
                <form method='post'>
                <td><input autocomplete='off' class='modify' value='%s' name='first_name' size='12'></td>
                <td><input autocomplete='off' class='modify' value='%s' name='last_name' size='12'></td>
                <td><input autocomplete='off' class='modify' value='%s' name='age' size='3'></td>
                <td><input autocomplete='off' class='modify' value='%s' name='email' size='30'></td>
                <td><input readonly class='modify' value='%s' size='3'></td>
                <td>
                <div class='btn'>
                <button formaction='update' type='submit' class='btn btn-warning'><i class='fa fa-pencil' aria-hidden='true'></i> Edit</button> 
                <button formaction='delete' class='btn btn-warning'><i class='fa fa-trash' aria-hidden='true'></i> Delete</button>
                </div>
                </td>
                <input type='hidden' name='id' value='%s'> 
                </form>
            </tr>",$client["first_name"], $client["last_name"], $client["age"], $client["email"], $insurance, $client["ID"]);   

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