<?php
   $flights = unserialize($_SESSION["flights"]);
   if($_POST["confirm"] == "true")
    {
        $flights[$_SESSION["reservation"]["destination"]]->removeSeats($_SESSION["reservation"]["total_passenger"]);
        echo "confirmation";
    }
    else
    {
        echo "annulation";
    }
    $_SESSION["flights"] = serialize($flights);
?>