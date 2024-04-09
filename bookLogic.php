<?php
require_once 'Database.php';

class bookLogic
{
        private $uri;
        private $get;
        private $post;
        private $error_message = "";
        private $message;


        public function __construct($uri, $get, $post)
        {
                session_start(); //
                $this->uri = $_SERVER['REQUEST_URI'];
                $this->get = $get;
                $this->post = $post;
        }

        public function run()
        {
                switch ($this->uri) {
                        case '/':
                                if ($this->isLoggedIn()) {
                                        $this->servePage('index.html');
                                } else {
                                        $this->servePage('index.html');
                                }
                                break;
                        case '/login':
                                $this->loginLogic();
                                break;

S

                        case '/signup':
                                $this->signupLogic();
                                break;
                        case '/logout':
                                $this->logoutLogic();
                        default:
                                $this->pageNotFound();
                                break;
                }
        }
        private function isLoggedIn()
        {
                return isset($_SESSION['user']);
        }

        private function loginLogic()
        {
                $database = new Database();
                $dbConnector = $database->getDbConnector();

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $this->error_message = "Error logging in - Name and email";
                        $userID = $_POST['uerid'] ?? '';
                        $password = $_POST['password'] ?? '';
                }
                $this->showLogin();



        }
        public function showLogin($message = "")
        {
                $message = "";
                if (!empty($this->error_message)) {
                        $message = "<div class='alert alert-danger'>{$this->error_message}</div>";
                }
                if (!empty($this->error_message)) {
                        $message = "<div class='alert alert-danger'>{$this->error_message}</div>";
                }
                include ("login.php");
        }

        private function logoutLogic()
        {

        }

        private function signupLogic()
        {

        }
}