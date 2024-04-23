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
                                        $this->servePage('index.php');
                                } else {
                                        $this->servePage('index.php');
                                }
                                break;
                        case '/login':
                                $this->loginLogic();
                                break;



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

        private function servePage($page){
                include $page;
        }

        private function isLoggedIn()
        {
                return isset($_SESSION['user']);
        }

        private function loginLogic()
        {
                $database = new Database();
                $dbConnector = $database->getConnector();

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $this->error_message = "Error logging in - Name and email";
                        $userID = $_POST['userid'] ?? '';
                        $password = $_POST['password'] ?? '';


                        if (empty($errorMessages)) {
                                $stmt = $dbConnector->prepare("SELECT * FROM User WHERE user_id = :userid");
                                $stmt->execute(['userid' => $userID]);
                                if ($user = $stmt->fetch()) {
                                        // Check if user exists and password is correct
                                        if (password_verify($password, $user['password'])) {
                                                $_SESSION['user'] = $user;
                                                header("Location: /");
                                                exit;
                                        } else {
                                                $this->error_message = "Authentication failed. Please check your credentials.";
                                        }
                                } else {
                                        $this->error_message = "Authentication failed. Please check your credentials.";
                                }
                        }
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
                $database = new Database();
                $dbConnector = $database->getConnector();

                if (!isset($_SESSION['errorMessages'])) {
                        $_SESSION['errorMessages'] = [];
                }

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $firstName = $_POST['first_name'] ?? '';
                        $lastName = $_POST['last_name'] ?? '';
                        $email = $_POST['email'] ?? '';
                        $phone = $_POST['phone'] ?? '';
                        $password = $_POST['password'] ?? '';
                        $confirmPassword = $_POST['confirm_password'] ?? '';

                        // Validate input and password confirmation
                        if (empty($firstName) || empty($lastName) || empty($email) || empty($phone)) {
                                $_SESSION['errorMessages'][] = "All fields are required";
                        }

                        if ($password !== $confirmPassword) {
                                $_SESSION['errorMessages'][] = "Passwords do not match";
                        }

                        if (empty($_SESSION['errorMessages'])) {
                                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                                try {
                                        $stmt = $dbConnector->prepare("INSERT INTO User (first_name, last_name, email, phone, user_password) VALUES (?, ?, ?, ?, ?)");
                                        $result = $stmt->execute([$firstName, $lastName, $email, $phone, $hashedPassword]);

                                        if ($result) {
                                                header("Location: login.php");
                                                exit;
                                        }
                                } catch (PDOException $e) {
                                        error_log('SignUp Error: ' . $e->getMessage());
                                        $_SESSION['errorMessages'][] = "An error occurred during signup. Please try again.";
                                }
                        }
                }
        }
}