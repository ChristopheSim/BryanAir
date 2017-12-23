<?php
    if(empty($_SESSION["status"]) || $_SESSION["status"] != 3)
    {
        header('Location: ./');
        exit();
    }

        
    $reservation = unserialize($_SESSION["reservation"]);
    $clients = $reservation->getClients();
    $tags["title"] = "Confirmation";

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
        $reservation->resetClients();
        throw new Exception("NEED ONE OVER 18");
    }

    $_SESSION["status"] = 4;
    if($_POST["confirm"] == "true")
    {
  
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) 
        {
            die("Connection failed: " . mysqli_connect_error());
        }

        // add client and reservations in DB
        $ids = $reservation->save($conn);

        mysqli_close($conn);
        header('Location: resumer');
        die();
    }
    else
    {
        unset($_SESSION["reservation"]);
        header('Location: home');
    }

?>