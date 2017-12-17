<?php
    if(empty($_SESSION["status"]) || $_SESSION["status"] != 3)
    {
        header('Location: ./');
        exit();
    }


   $reservation = unserialize($_SESSION["reservation"]);
   $clients = $reservation->getClients();
    $tags["title"] = "Confirmation";

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
            throw new Exception("NEED ONE OVER 18");
        }
     
        
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "";
        $ids = array();

        // add client and reservations in DB
        $ids = $reservation->save($conn);

        mysqli_close($conn);
       echo "confirmation";
    }
    else
    {
        unset($_SESSION["reservation"]);
        echo "annulation";
    }
    $_SESSION["status"] = 4;
?>