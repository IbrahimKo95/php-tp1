<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\SQL;
use App\Models\User as UserModel;

class User
{

    public function __construct()
    {
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
            if (empty($_POST['fullname']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['password_confirmation'])) {
                $_SESSION['flash']['error'] = 'All fields are required.';
                header('Location: /user/add');
                exit();
            }

            $fullname = trim($_POST['fullname']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $passwordConfirmation = $_POST['password_confirmation'];


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
                // Prepare the SQL query to check if the user already exists
                $userModel = new UserModel();
                $user = $userModel->getOneByEmail($email);
                if ($user) {
                    $_SESSION['flash']['error'] = 'User already exists with this email.';
                    header('Location: /user/add');
                    exit();
                }
                // Execute the query
                if ($userModel->insert($email, $fullname, $hashedPassword)) {
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
