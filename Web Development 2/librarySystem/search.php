<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Books</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include('header.php'); ?>

    <header>
        <h1>Search for a Book</h1>
    </header>

    <div id="form">
        <form action="books.php" method="GET">
            <div class="input-containerca">
                <label for="title">Search by title, author or ISBN:</label>
                <input type="text" id="title" name="title" placeholder="Search..." value="<?php echo isset($_GET['title']) ? htmlspecialchars($_GET['title']) : ''; ?>">
            </div>

            <div class="input-containerca">
                <label for="category">Genre:</label>
                <select id="category" name="category">
                    <option value="">Select Genre</option>
                    <?php
                        session_start();
                        require_once 'calibrary.php';
                        
                        $sql = "SELECT CategoryID, CategoryDescription FROM category";
                        $select_result = $conn->query($sql);
                        if ($select_result->num_rows > 0) {
                            while ($row = $select_result->fetch_assoc()) {
                                $selected = (isset($_GET['category']) && $_GET['category'] == $row['CategoryDescription']) ? "selected" : "";
                                echo "<option value=\"" . htmlspecialchars($row['CategoryDescription']) . "\" $selected>" . htmlspecialchars($row['CategoryDescription']) . "</option>"; 
                            }
                        }
                    ?>
                </select>
            </div>

            <button type="submit" id="sbt">Search</button>
        </form>
    </div>

    <?php include('footer.php'); ?> 
</body>
</html>
