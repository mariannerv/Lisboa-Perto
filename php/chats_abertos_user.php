<?php

session_start();

require 'abreconexao.php'; 

// Check Database Connection
if ($conn) {
    echo "<div style='color: green; font-weight: bold;'>Connected to database successfully!</div>";
} else {
    echo "<div style='color: red; font-weight: bold;'>Failed to connect to database!</div>";
}

// Check Session Variable
if (!isset($_SESSION['logged_in'])) {
    echo "<div style='color: orange; font-weight: bold;'>Session not logged in!</div>";
} else {
    echo "<div style='color: blue; font-weight: bold;'>Session logged in!</div>";
    $userEmail = $_SESSION['email'];
    
    // Construct SQL Query
    $sql = "SELECT DISTINCT `chat_id` FROM `chat` WHERE `id_utilizador` = '$userEmail'";
    
    // Execute SQL Query
    $result = $conn->query($sql);
    
    // Check if Query was Successful
    if ($result) {
        // Check if any rows were returned
        if ($result->num_rows > 0) {
            // Output Results
            echo "<div style='margin-top: 10px; font-weight: bold;'>Distinct chat IDs:</div>";
            echo "<ul style='list-style-type: none; padding: 0;'>";
            while ($row = $result->fetch_assoc()) {
                echo "<li style='margin-left: 20px;'>" . $row['chat_id'] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<div style='color: gray; font-weight: bold;'>No distinct chat IDs found for this user.</div>";
        }
    } else {
        echo "<div style='color: red; font-weight: bold;'>Error executing SQL query: " . $conn->error . "</div>";
    }
}

?>
