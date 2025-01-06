<?php
session_start();
require_once 'calibrary.php';

$error_message = '';
$success_message = '';

if (isset($_POST['create'])) {
    $username = $_POST['user'];
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $confirm_password = $_POST['pass2'];
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $address1 = $_POST['Add1'];
    $address2 = $_POST['Add2'];
    $city = $_POST['city'];
    $telephone = $_POST['tp'];
    $mobile = $_POST['mb'];

    // Check if any required field is empty
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password) || empty($first_name) || empty($last_name) || empty($address1) || empty($city) || empty($telephone) || empty($mobile)) {
        $error_message = 'Please fill in all the fields.';
    }
    // Check if the passwords match
    elseif ($password !== $confirm_password) {
        $error_message = 'Passwords do not match.';
    } 
    elseif(strlen($password) !=6) {
        $error_message = 'Password must be 6 characters long.';
    }
    elseif(strlen($telephone) !=10) {
        $error_message = 'Telephone must be 10 digits long.';
    }
    elseif(strlen($mobile) !=10) {
        $error_message = 'Mobile must be 10 digits long.';
    }
    else {
        // Check if the username already exists
        $sql_check_username = "SELECT * FROM users WHERE Username = '$username'";
        $result = $conn->query($sql_check_username);

        if ($result->num_rows > 0) {
            $error_message = 'Username is already taken, please choose another one.';
        } else {
            // Insert the new user into the database
            $sql = "INSERT INTO users (Username, Email, Pass, Firstname, Surname, Addressline1, Addressline2, City, Telephone, Mobile) 
                    VALUES ('$username','$email', '$password', '$first_name', '$last_name', '$address1', '$address2', '$city', '$telephone', '$mobile')";

            if ($conn->query($sql) === TRUE) {
                $success_message = 'Account created successfully!';
            } else {
                $error_message = 'Error: ' . $conn->error;
            }
        }
        $conn->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<form action="login.php" method="POST" class="logout-form">
            <button type="submit" name="login" class="logout-btn">Login</button>
        </form>
    <div id="title">
        <h1>Create Account</h1>
    </div>

    <div id="form">

        <?php if (!empty($error_message)) { ?>
            <div class="error-message" style="color: red; text-align: center;"><?= $error_message; ?></div>
        <?php } ?>
        <?php if (!empty($success_message)) { ?>
            <div class="success-message" style="color: green; text-align: center;"><?= $success_message; ?></div>
        <?php } ?>

        <form name="createAccountForm" method="POST">
            <div class="input-containerca">
                <label for="user">Username</label>
                <input type="text" id="user" name="user" required>
            </div>

            <div class="input-containerca">
                <label for="user">Email</label>
                <input type="text" id="user" name="email" required>
            </div>

            <div class="input-containerca">
                <label for="pass">Password</label>
                <input type="password" id="pass" name="pass" required>
            </div>

            <div class="input-containerca">
                <label for="pass2">Confirm Password</label>
                <input type="password" id="pass2" name="pass2" required>
            </div>

            <div class="input-containerca">
                <label for="fname">Enter your first name</label>
                <input type="text" id="fname" name="fname" required>
            </div>

            <div class="input-containerca">
                <label for="lname">Enter your last name</label>
                <input type="text" id="lname" name="lname" required>
            </div>

            <div class="input-containerca">
                <label for="Add1">Address Line 1</label>
                <input type="text" id="Add1" name="Add1" required>
            </div>

            <div class="input-containerca">
                <label for="Add2">Address Line 2</label>
                <input type="text" id="Add2" name="Add2">
            </div>

            <div class="input-containerca">
                <label for="city">City</label>
                <input type="text" id="city" name="city" required>
            </div>

            <div class="input-containerca">
                <label for="tp">Telephone</label>
                <input type="text" id="tp" name="tp" required>
            </div>

            <div class="input-containerca">
                <label for="mb">Mobile</label>
                <input type="text" id="mb" name="mb" required>
            </div>

            <input type="submit" id="create" value="Create" name="create">
        </form>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>