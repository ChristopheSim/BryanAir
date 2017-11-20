<?php
   $flights = unserialize($_SESSION["flights"]);
   $clients = unserialize($_SESSION["clients"]);
   if($_POST["confirm"] == "true")
    {
        $flights[$_SESSION["reservation"]["destination"]]->removeSeats($_SESSION["reservation"]["total_passenger"]);
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
    print_r($clients);
    $_SESSION["clients"] = serialize($clients);
    $_SESSION["flights"] = serialize($flights);
?>