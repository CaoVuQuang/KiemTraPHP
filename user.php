<?php
session_start();

class Auth {
    private $conn;

    function __construct($conn) {
        $this->conn = $conn;
    }

    // Function to authenticate user
    function authenticateUser($username, $password) {
        $username = mysqli_real_escape_string($this->conn, $username);
        $password = mysqli_real_escape_string($this->conn, $password);
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = $this->conn->query($sql);
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            return true;
        } else {
            return false;
        }
    }

    // Check if the user is logged in and has admin role
    function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] == 'admin';
    }

    // Logout function
    function logout() {
        session_unset();
        session_destroy();
    }
}

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ql_nhansu";

// Establish connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize Auth class
$auth = new Auth($conn);

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($auth->authenticateUser($username, $password)) {
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>
