<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = ""; // Default password for XAMPP
$dbname = "LabDb";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Oops! Connection failed: " . $conn->connect_error);
}

// Query to select all data from the Product table
$sql = "SELECT * FROM Product";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display the data in a table format
    echo "<h2>Product List</h2>";
    echo "<table border='1' cellpadding='10' cellspacing='0'>";
    echo "<tr><th>ID</th><th>Product Name</th><th>Price</th><th>Quantity</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["ProductID"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["PName"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Price"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Stock"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Description"]) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>It looks like there are no products available right now. Please check back later.</p>";
}

// Close the connection
$conn->close();
?>
