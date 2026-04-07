<?php
require "include/conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $criteria = $_POST['criteria'];
    $weight = $_POST['weight'];
    $attribute = $_POST['attribute'];

    // Insert data into the database
    $sql = "INSERT INTO saw_criterias (criteria, weight, attribute) VALUES (?, ?, ?)";

    // Prepare the statement
    if ($stmt = $db->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("sds", $criteria, $weight, $attribute);

        // Execute the statement
        if ($stmt->execute()) {
            header("location:./bobot.php");
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: " . $db->error;
    }
} else {
    echo "Invalid request method.";
}
?>
