<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogIn</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
    <div id="title">
        <h1>Library</h1>
    </div>
    <div id="form">
        <h1>Login</h1>

        <?php if (isset($error_message)) { 
            ?>
            <div class="error" style="color: red; text-align: center;">
                <?= $error_message; ?>
            </div><?php } ?>

        <form action="loginscript.php" method="POST">

            <div class="input-container">
                <span class="material-icons">account_circle</span>
                <input type="text" id="user" name="user" placeholder="Username..." required>
            </div>

            <div class="input-container">
                <span class="material-icons">lock</span>
                <input type="password" id="pass" name="pass" placeholder="Password..." required>
            </div>

            <input type="submit" id="sbt" value="Login" name="submit">

            <div class="new-account">
                <a href="createAccount.php" id="create-account">Create New Account</a>
            </div>

        </form>

    </div>
    <?php include('footer.php'); ?>
</body>
</html>