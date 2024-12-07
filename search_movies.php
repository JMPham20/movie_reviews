<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['search_term'])) {
    $search_term = "%" . $_POST['search_term'] . "%";
    
    // Query to search the TMDB_Title table for movie title or genres
    $sql = "SELECT title, vote_average, release_date, genres, overview
            FROM TMDB_Title
            WHERE title LIKE ? OR genres LIKE ?";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $search_term, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Loop through the result and display movie details
        while ($row = $result->fetch_assoc()) {
            echo "<div class='movie'>";
            echo "<h4>" . $row['title'] . "</h4>";
            echo "<p><strong>Vote Average:</strong> " . $row['vote_average'] . "</p>";
            echo "<p><strong>Release Date:</strong> " . $row['release_date'] . "</p>";
            echo "<p><strong>Genres:</strong> " . $row['genres'] . "</p>";
            echo "<p><strong>Overview:</strong> " . $row['overview'] . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No movies found.</p>";
    }

    // Close the prepared statement
    $stmt->close();
}
?>
