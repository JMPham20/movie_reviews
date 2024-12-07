<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['search_term'])) {
    $search_term = "%" . $_POST['search_term'] . "%";
    $sql = "SELECT name, birth_year, known_for_titles FROM Person WHERE name LIKE ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p><strong>" . $row['name'] . "</strong> - Born: " . $row['birth_year'] . "<br>Known For: " . $row['known_for_titles'] . "</p>";
        }
    } else {
        echo "<p>No people found.</p>";
    }

    $stmt->close();
}
?>
