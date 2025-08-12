<?php

    interface UserInterface{
        public function Login($username, $userPassword);
        public function Register($username, $fname, $lname, $userPassword, $phone, $rPass);
        public function Logout();


    }