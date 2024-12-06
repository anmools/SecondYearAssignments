<?php
session_start();
require_once 'calibrary.php';

if (!isset($_SESSION["user"])) {
    echo "You need to be logged in to reserve a book.";
    exit;  
} else {
    $username = $_SESSION["user"]; 
}

//unreserve
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['unreserve'])) {
    $isbn = $_POST['isbn'];
    $unreserve_sql = "UPDATE books SET Reserved = 0, ReservedBy = NULL WHERE ISBN = ? AND ReservedBy = ?";
    $stmt = $conn->prepare($unreserve_sql);
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }
    $stmt->bind_param('ss', $isbn, $username);
    $stmt->execute();
    $stmt->close();
}

//reserved books
$sql = "SELECT b.ISBN, b.BookTitle, b.Author, b.Edition, b.Year, c.CategoryDescription, b.ReservedBy FROM books b INNER JOIN category c ON b.Category = c.CategoryID WHERE b.ReservedBy = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('MySQL prepare error: ' . $conn->error);
}
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Reservations</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <a href="index.php" class="back-button-link">
        <button class="back-button">Back to Home</button>
    </a>
    <header>
        <h1>Your Book Reservations</h1>
    </header>

    <div id="reserved-books">
        <?php if ($result->num_rows > 0): ?>
            <table id="booktable">
                <thead>
                    <tr>
                        <th>ISBN</th>
                        <th>Book Title</th>
                        <th>Author</th>
                        <th>Edition</th>
                        <th>Year</th>
                        <th>Category</th>
                        <th>Reserved By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['ISBN']) ?></td>
                            <td><?= htmlspecialchars($row['BookTitle']) ?></td>
                            <td><?= htmlspecialchars($row['Author']) ?></td>
                            <td><?= htmlspecialchars($row['Edition']) ?></td>
                            <td><?= htmlspecialchars($row['Year']) ?></td>
                            <td><?= htmlspecialchars($row['CategoryDescription']) ?></td>
                            <td><?= htmlspecialchars($row['ReservedBy']) ?></td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="isbn" value="<?= htmlspecialchars($row['ISBN']) ?>">
                                    <input type="submit" name="unreserve" class="unreserve-button" value="Unreserve">
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have no reserved books at this time.</p>
        <?php endif; ?>
    </div>

    <footer>
        <?php include('footer.php'); ?>
    </footer>
</body>
</html>
