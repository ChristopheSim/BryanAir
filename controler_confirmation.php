<?php
    if(empty($_SESSION["status"]) || $_SESSION["status"] != 3)
    {
        header('Location: ./');
        exit();
    }

    if(empty($_POST["confirm"]) || !($_POST["confirm"]=="true" && $_POST["confirm"]=="false"))

   $reservation = unserialize($_SESSION["reservation"]);
   $clients = $reservation->getClients();


   if($_POST["confirm"] == "true")
    {
        //check for one client at least 18 YO
        $maj = false;

        foreach($clients as $client)
        {
                if($client->getAge() >= 18)
                {
                    $maj = true;
                    break;
                }
        }
        if(!$maj)
        {
            echo "NEED ONE OVER 18";
            $_SESSION["status"] = "ageError";
            exit();
        }
     
        
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "";
        $ids = array();

        // add client in DB
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, 'INSERT INTO clients (first_name, last_name, email, age)
                                        VALUES (?, ?, ?, ?)')) {
            foreach($clients as $client)
            {
                $first_name = $client->getFirstName();
                $last_name = $client->getLastName();
                $age = $client->getAge();
                $email = $reservation->getEmail();
                
                    /* Association des variables SQL */
                    mysqli_stmt_bind_param($stmt, "ssss", $first_name,$last_name, $email, $age);
                
                    /* Exécution de la requête */
                if (mysqli_stmt_execute($stmt)) {
                    echo "New record created successfully";
                    array_push($ids, mysqli_insert_id($conn));
                }
                else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
        }

        //add reservation in DB
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, 'INSERT INTO reservation (client, flight)
                                        VALUES (?,?)')) {
            foreach($ids as $id)
            {                
                    /* Association des variables SQL */
                    $flight_number = $reservation->getOBFlight()->getNumber();
                    mysqli_stmt_bind_param($stmt, "ss", $id ,$flight_number);
                
                    /* Exécution de la requête */
                if (mysqli_stmt_execute($stmt)) {
                    echo "New record created successfully";
                }
                else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
        }
        
        //add retrun reservation in DB
        $return_flight = $reservation->getRFlight();
        if($return_flight != null)
        {
            $stmt = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($stmt, 'INSERT INTO reservation (client, flight)
                                            VALUES (?,?)')) {
                foreach($ids as $id)
                {                  
                        /* Association des variables SQL */
                        $flight_number = $return_flight->getNumber();
                        mysqli_stmt_bind_param($stmt, "ss", $id ,$flight_number);
                    
                        /* Exécution de la requête */
                    if (mysqli_stmt_execute($stmt)) {
                        echo "New record created successfully";
                    }
                    else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                }
            }
        }

        mysqli_close($conn);
        //$flights[$_SESSION["reservation"]["destination"]]->removeSeats($_SESSION["reservation"]["total_passenger"]);
        echo "confirmation";
    }
    else
    {
        for($i = 0; $i < $reservation.getTotalPassenger(); $i++)
        {
            array_pop($clients);
                
        }
        unset($_SESSION["reservation"]);
        echo "annulation";
    }
    $_SESSION["clients"] = serialize($clients);
    $_SESSION["status"] = 4;
    unset($_SESSION["clients"]);
?>