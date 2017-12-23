<?php
    class Client
    {
        private $last_name;
        private $first_name;
        private $age;
        
        function __construct($first_name , $last_name, $age)
        {
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->age = $age;
        }

        function getLastName()
        {
            return $this->last_name;
        }
        function getFirstName()
        {
            return $this->first_name;
        }
        function getAge()
        {
            return $this->age;
        }
     
    }
?>