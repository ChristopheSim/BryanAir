<?php
Class Reservation
{
    private $total_passenger;
    private $clients;
    private $outbound_fligt;
    private $return_flight;
    private $inssurance;
    private $email;

    function __construct($total_passenger, $inssurance, $email, $obFlight, $rFlight)
    {
        $this->total_passenger = $total_passenger;
        $this->inssurance = $inssurance;
        $this->email = $email;
        $this->outbound_fligt = $obFlight;
        $this->return_flight = $rFlight;
        $this->clients = array();
    }

    function getTotalPassenger()
    {
        return $this->total_passenger;
    }

    function getRegisterdPassenger()
    {
        return count($this->clients);
    }

    function getInssurance()
    {
        return $this->inssurance;
    }

    function addClient($client)
    {
        array_push($this->clients, $client);
    }

    function getClients()
    {
        return $this->clients;
    }

    function getEmail()
    {
        return $this->email;
    }

    function getOBFlight()
    {
        return $this->outbound_fligt;
    }

    function getRFlight()
    {
        return $this->return_flight;
    }
}

?>
