<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Home</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
    <?php include('header.php'); ?>

        <h1>Welcome to the Library</h1>
    </header>

    <div id="homepage">
        <h2>About the Library System</h2>

        <ul style="list-style-type: none; padding: 0;">
            <li>📚 Search for books by title, author, or category or view your reservations📖</li>
        </ul>

        <div class="button-container">
            <a href="search.php">
                <button>Search for Books</button>
            </a>
            <a href="reservations.php">
                <button>Your Reservations</button>
            </a>
        </div>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>
