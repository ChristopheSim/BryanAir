<?php
    class Flight
    {
        private $flight_number;
        private $available_seat;
        private $depart_time;
        private $destination;

        function __construct($destination, $depart_time, $flight_number)
        {
            $this->destination = $destination;
            $this->depart_time = $depart_time;
            $this->flight_number = $flight_number;
            $this->available_seat = 150; 
        }

        function getDestination()
        {
            return $this->destination;
        }

        function getDepartTime()
        {
            return $this->depart_time;
        }

        function getAvailableSeat()
        {
            return $this->available_seat;
        }

        function getFlightNumber()
        {
            return $this->flight_number;
        }
    }
