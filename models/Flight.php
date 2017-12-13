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
    }
