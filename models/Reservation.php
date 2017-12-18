<?php
Class Reservation
{
    private $total_passenger;
    private $clients;
    private $outbound_flight;
    private $return_flight;
    private $inssurance;
    private $email;

    function __construct($total_passenger, $inssurance, $email, $obFlight, $rFlight)
    {
        $this->total_passenger = $total_passenger;
        $this->inssurance = $inssurance;
        $this->email = $email;
        $this->outbound_flight = $obFlight;
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

    function resetClients()
    {
        $this->clients = array();
    }

    function getEmail()
    {
        return $this->email;
    }

    function getOBFlight()
    {
        return $this->outbound_flight;
    }

    function getRFlight()
    {
        return $this->return_flight;
    }

    function getPrice($conn)
    {
        $price = 0;
        $price += $this->outbound_flight->getPrice($conn) * count($this->clients);
        if($this->return_flight != null)
        {
            $price += $this->return_flight->getPrice($conn) * count($this->clients); 
            
            
        }
        if($this->inssurance)
        {
            //$price += 8;
        }
        return $price;
    }

    private function saveClients($conn)
    {
        $ids = array();
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, 'INSERT INTO clients (first_name, last_name, email, age)
                                        VALUES (?, ?, ?, ?)')) {
            foreach($this->clients as $client)
            {
                $first_name = $client->getFirstName();
                $last_name = $client->getLastName();
                $age = $client->getAge();
                
                mysqli_stmt_bind_param($stmt, "ssss", $first_name,$last_name, $this->email, $age);
                
                if (mysqli_stmt_execute($stmt)) {
                    echo "New record created successfully";
                    array_push($ids, mysqli_insert_id($conn));
                }
                else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
        }
        return $ids;
    }

    private function saveReservations($conn, $ids, $flight)
    {
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, 'INSERT INTO reservation (client, flight, inssurance)
                                        VALUES (?,?,?)')) {
            foreach($ids as $id)
            {                
                    $flight_number = $flight->getNumber();
                    mysqli_stmt_bind_param($stmt, "sss", $id ,$flight_number, $this->inssurance);

                if (mysqli_stmt_execute($stmt)) {
                }
                else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
        }
        return $ids;
    }

    function save($conn)
    {
        $ids = $this->saveClients($conn);
        $this->saveReservations($conn, $ids, $this->outbound_flight);
        if($this->return_flight != null)
        {
            $this->saveReservations($conn, $ids, $this->return_flight);
        }
    }
}
?>
