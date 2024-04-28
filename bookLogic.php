<?php
require_once 'Database.php';

class bookLogic
{
        private $input;

        private $errormessage;
        private $message;

        public function __construct($get)
        {
                session_start(); //
                // $this->uri = $uri;
                $this->get = $get;
                // $this->post = $post;
        }
}