<?php 
session_start();
require_once 'calibrary.php';
unset($_SESSION["user"]);

if (isset($_POST["user"]) && isset($_POST["pass"])) {
    $username = $_POST["user"];
    $password = $_POST["pass"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE Username = ? AND Pass = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION["user"] = $username;
        $_SESSION["success"] = "Logged in.";
        header('Location: index.php');
        return;
    } else {
        $_SESSION["error"] = "Incorrect username or password.";
        header('Location: login.php');
        return;
    }
} else if (count($_POST) > 0) {
    $_SESSION["error"] = "Missing Required Information.";
    header('Location: login.php');
    return;
}
?>
