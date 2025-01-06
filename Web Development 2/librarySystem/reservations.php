<?php include('header.php'); ?>
<?php
require_once 'calibrary.php';

if (!isset($_SESSION["user"])) {
    echo "You need to be logged in to reserve a book.";
    exit;
} else {
    $username = $_SESSION["user"];
}

// Handle unreserve
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

// Pagination setup
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 5;
$offset = ($page - 1) * $records_per_page;

// Get total record count
$total_sql = "SELECT COUNT(*) AS total FROM books WHERE ReservedBy = ?";
$total_stmt = $conn->prepare($total_sql);
if ($total_stmt === false) {
    die('MySQL prepare error: ' . $conn->error);
}
$total_stmt->bind_param('s', $username);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $records_per_page);

// Fetch paginated results
$sql = "SELECT b.ISBN, b.BookTitle, b.Author, b.Edition, b.Year, c.CategoryDescription, b.ReservedBy 
        FROM books b 
        INNER JOIN category c ON b.Category = c.CategoryID 
        WHERE b.ReservedBy = ? 
        LIMIT ?, ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('MySQL prepare error: ' . $conn->error);
}
$stmt->bind_param('sii', $username, $offset, $records_per_page);
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

            <!-- Pagination -->
            <div class="pagination">
                <?php
                $previous_disabled = ($page == 1) ? "disabled" : "";
                echo "<a href='?page=" . ($page - 1) . "' class='pagination-button $previous_disabled'>Previous</a>";

                for ($i = 1; $i <= $total_pages; $i++) {
                    $active = ($i === $page) ? "active" : "";
                    echo "<a href='?page=$i' class='pagination-button $active'>$i</a>";
                }

                $next_disabled = ($page == $total_pages) ? "disabled" : "";
                echo "<a href='?page=" . ($page + 1) . "' class='pagination-button $next_disabled'>Next</a>";
                ?>
            </div>
        <?php else: ?>
            <p class="no-books">You have no reserved books at this time.</p>
        <?php endif; ?>
    </div>

    <footer>
        <?php include('footer.php'); ?>
    </footer>
</body>
</html>
