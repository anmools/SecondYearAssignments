<?php
session_start(); 
require_once 'calibrary.php';  

// Ensure the user is logged in
if (!isset($_SESSION["user"])) {
    echo "You need to be logged in to reserve a book.";
    exit; 
} else {
    $username = $_SESSION["user"]; 
}

if (isset($_POST['isbn'])) {
    $isbn = $_POST['isbn']; 

    $check_query = "SELECT Reserved FROM books WHERE ISBN = ?";
    $stmt_check = $conn->prepare($check_query);
    $stmt_check->bind_param("s", $isbn);
    $stmt_check->execute();
    $stmt_check->store_result();
    $stmt_check->bind_result($reserved);
    $stmt_check->fetch();

    if ($reserved == 0) {
        $update_query = "UPDATE books SET Reserved = 1, ReservedBy = ? WHERE ISBN = ? AND Reserved = 0";
        $stmt_update = $conn->prepare($update_query);
        $stmt_update->bind_param("ss", $username, $isbn);  
        if ($stmt_update->execute()) {
            header("Location: books.php?reservation=success");
            exit;
        } else {
            echo "Error reserving the book.";
        }
        $stmt_update->close();
    } else {
        echo "This book is already reserved.";
    }
    $stmt_check->close();
} else {
    echo "Invalid request. ISBN not provided.";
}

$conn->close();
?>
