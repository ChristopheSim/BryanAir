<?php
   $clients = unserialize($_SESSION["clients"]);
   if($_POST["confirm"] == "true")
    {
        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "";
        $ids = array();

        // add client in DB
        foreach($clients as $client)
        {
            $sql = sprintf("INSERT INTO clients (first_name, last_name, email)
            VALUES ('%s', '%s', 'john@example.com')", $client->getFirstName(), $client->getLastName());

            if (mysqli_query($conn, $sql)) {
                echo "New record created successfully";
                $clients = null;
                array_push($ids, mysqli_insert_id($conn));
            }
            else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }

        //add reservation in DB
        foreach($ids as $id)
        {
            $sql = sprintf("INSERT INTO reservation (client, flight)
            VALUES ('%s', '%s')",$id, $_SESSION["flight"]);
            if (mysqli_query($conn, $sql)) {
                echo "New record created successfully";
                $clients = null;
                array_push($ids, mysqli_insert_id($conn));
            }
            else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }

        

        mysqli_close($conn);
        //$flights[$_SESSION["reservation"]["destination"]]->removeSeats($_SESSION["reservation"]["total_passenger"]);
        echo "confirmation";
    }
    else
    {
        for($i = 0; $i < $_SESSION["reservation"]["total_passenger"]; $i++)
        {
            array_pop($clients);
                
        }
        unset($_SESSION["reservation"]);
        echo "annulation";
    }
    $_SESSION["clients"] = serialize($clients);
    unset($_SESSION["clients"]);
?>