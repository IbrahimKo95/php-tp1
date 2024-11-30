<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\SQL; // Now the SQL class should be correctly recognized

class User
{
    protected $db;

    public function __construct()
    {
        // Use the Singleton pattern to get the instance of SQL
        $this->db = SQL::getBdd();

        // Ensure that the session is started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Display registration form
    public function register(): void
    {
        $view = new View("User/register.php", "back.php");
        // You can pass additional data to the view, like validation errors or messages
    }

    // Handle user registration logic
    public function registerbd(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_user_btn'])) {
            $fullname = trim($_POST['fullname']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $passwordConfirmation = $_POST['password_confirmation'];

            // Validate inputs
            if (empty($fullname) || empty($email) || empty($password) || empty($passwordConfirmation)) {
                $_SESSION['flash']['error'] = 'All fields are required.';
                header('Location: /user/add');
                exit();
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['flash']['error'] = 'Invalid email format.';
                header('Location: /user/add');
                exit();
            }

            if ($password !== $passwordConfirmation) {
                $_SESSION['flash']['error'] = 'Passwords do not match.';
                header('Location: /user/add');
                exit();
            }

            // Hash the password for security
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insert user into the database directly using SQL class
            try {
                // Prepare the SQL query to insert the user
                $query = "INSERT INTO users (fullname, email, password) VALUES (:fullname, :email, :password)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(":fullname", $fullname);
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":password", $hashedPassword);

                // Execute the query
                if ($stmt->execute()) {
                    $_SESSION['flash']['success'] = 'User registered successfully.';
                    header('Location: /user/add');
                } else {
                    $_SESSION['flash']['error'] = 'An error occurred, please try again.';
                    header('Location: /user/add');
                }
            } catch (\PDOException $e) {
                $_SESSION['flash']['error'] = 'Database error: ' . $e->getMessage();
                header('Location: /user/add');
            }

            exit();
        }
    }



}
