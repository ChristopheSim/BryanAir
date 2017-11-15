<?php
    class Client
    {
        private $last_name;
        private $first_name;
        private $age;
        private $Flights = array();
        
        function __construct($first_name , $last_name, $age)
        {
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->age = $age;
        }

        function setLastName($last_name)
        {
            $this->last_name = $last_name;
        }

        function setFirstName($first_name)
        {
            $this->first_name = $first_name; 
        }

        function setAge($age)
        {
            $this->age = $age;
        }

        function addReservation($Flight)
        {
            array_push($this->Flights, $Flight);
        }

        function cancelReservation()
        {

        }

        


    }