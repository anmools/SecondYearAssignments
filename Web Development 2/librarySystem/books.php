<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include('header.php'); ?>
<?php
require_once 'calibrary.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 
$title = isset($_GET['title']) ? $_GET['title'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 5;
$offset = ($page - 1) * $records_per_page; 

$sql = "SELECT b.ISBN, b.BookTitle, b.Author, b.Edition, b.Year, c.CategoryDescription, b.Reserved, b.ReservedBy FROM books b INNER JOIN category c ON b.Category = c.CategoryID WHERE 1";

if (!empty($title)) {
    $sql .= " AND (b.BookTitle LIKE ? OR b.Author LIKE ? OR b.ISBN LIKE ?)";
}

if (!empty($category)) {
    $sql .= " AND c.CategoryDescription = ?";
}

$sql .= " LIMIT $records_per_page OFFSET $offset";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('MySQL prepare error: ' . $conn->error);
}

if (!empty($title) && !empty($category)) {
    $title_like = "%$title%";
    $stmt->bind_param('ssss', $title_like, $title_like, $title_like, $category);
} elseif (!empty($title)) {
    $title_like = "%$title%";
    $stmt->bind_param('sss', $title_like, $title_like, $title_like);
} elseif (!empty($category)) {
    $stmt->bind_param('s', $category);
} else {
    $stmt->execute();
}

$stmt->execute();
$result = $stmt->get_result();

// Display results
echo '<div id="search-results">';
if ($result->num_rows > 0) {
    echo "<h1>Search Results</h1>";
    echo "<table id='booktable'>";
    echo "<thead>
            <tr>
                <th>ISBN</th>
                <th>Book Title</th>
                <th>Author</th>
                <th>Edition</th>
                <th>Year</th>
                <th>Category</th>
                <th>Reserved</th>
                <th>Action</th>
            </tr>
          </thead>";
    echo "<tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['ISBN']) . "</td>";
        echo "<td>" . htmlspecialchars($row['BookTitle']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Author']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Edition']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Year']) . "</td>";
        echo "<td>" . htmlspecialchars($row['CategoryDescription']) . "</td>";
        echo "<td>" . ($row['Reserved'] ? 'Yes' : 'No') . "</td>";

        if ($row['Reserved'] == 0) {
            echo "<td>
                    <form method='POST' action='reserve.php'>
                        <input type='hidden' name='isbn' value='" . htmlspecialchars($row['ISBN']) . "'>
                        <input type='submit' name='reserve' class='reserve-button' value='Reserve'>
                    </form>
                  </td>";
        } else {
            echo "<td></td>";
        }
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";

    $total_sql = "SELECT COUNT(*) AS total FROM books b INNER JOIN category c ON b.Category = c.CategoryID WHERE 1";
    if (!empty($title)) {
        $total_sql .= " AND (b.BookTitle LIKE '%$title%' OR b.Author LIKE '%$title%' OR b.ISBN LIKE '%$title%')";
    }
    if (!empty($category)) {
        $total_sql .= " AND c.CategoryDescription = '$category'";
    }

    $total_result = $conn->query($total_sql);
    $total_row = $total_result->fetch_assoc();
    $total_records = $total_row['total'];
    $total_pages = ceil($total_records / $records_per_page);

    echo "<div class='pagination'>";
    $previous_disabled = ($page == 1) ? "disabled" : "";
    echo "<a href='?page=" . ($page - 1) . "' class='pagination-button $previous_disabled'>Previous</a>";

    for ($i = 1; $i <= $total_pages; $i++) {
        $active = ($i === $page) ? "active" : "";
        echo "<a href='?page=$i' class='pagination-button $active'>$i</a>";
    }

    $next_disabled = ($page == $total_pages) ? "disabled" : "";
    echo "<a href='?page=" . ($page + 1) . "' class='pagination-button $next_disabled'>Next</a>";
    echo "</div>";
} 
else 
{
    echo "<p>No books found matching your criteria.</p>";
}
echo '</div>';
$conn->close();
?>

<?php include('footer.php'); ?>
</body>
</html>
