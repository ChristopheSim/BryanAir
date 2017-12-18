<?php
    class Flight
    {
        private $flight_number;
        private $seats;
        private $departire;
        private $arrival;

        function __construct($departure, $arrival, $flight_number, $seats)
        {
            $this->departure = $departure;
            $this->arrival = $arrival;
            $this->flight_number = $flight_number;
            $this->seats = $seats; 
        }

        function getArrival()
        {
            return $this->arrival;
        }

        function getDeparture()
        {
            return $this->departure;
        }

        function getSeats()
        {
            return $this->seats;
        }

        function getNumber()
        {
            return $this->flight_number;
        }

        function getPrice($conn)
        {
           
            $sql = "SELECT price FROM flights WHERE departure = '$this->departure' && arrival = '$this->arrival' ";
            $result = mysqli_query($conn, $sql);
            $flight;
            if (mysqli_num_rows($result) > 0) 
            {
                $price = mysqli_fetch_assoc($result)["price"];
            } 
            else 
            {
                throw new Exception("No match found");
            }
            return intval($price);
        }

    }
