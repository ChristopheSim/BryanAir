<?php
    if(empty($_SESSION["status"]) || $_SESSION["status"] != 3)
    {
        header('Location: ./');
        exit();
    }

   $clients = unserialize($_SESSION["clients"]);

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
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, 'INSERT INTO clients (first_name, last_name, email, age)
                                        VALUES (?, ?, ?, ?)')) {
            foreach($clients as $client)
            {
                $first_name = $client->getFirstName();
                $last_name = $client->getLastName();
                $age = $client->getAge();
                
                    /* Association des variables SQL */
                    mysqli_stmt_bind_param($stmt, "ssss", $first_name,$last_name, $_SESSION["email"], $age);
                
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
                    mysqli_stmt_bind_param($stmt, "ss", $id ,$_SESSION["flight"]);
                
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
        $return_flight = $_SESSION["return"];
        if($return_flight != null)
        {
            $stmt = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($stmt, 'INSERT INTO reservation (client, flight)
                                            VALUES (?,?)')) {
                foreach($ids as $id)
                {                  
                        /* Association des variables SQL */
                        mysqli_stmt_bind_param($stmt, "ss", $id ,$return_flight);
                    
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
        for($i = 0; $i < $_SESSION["reservation"]["total_passenger"]; $i++)
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