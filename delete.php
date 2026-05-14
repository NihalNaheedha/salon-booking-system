<?php
session_start();
include("db.php");

// Admin check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Check if ID is passed
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Delete customer and their appointments (if any)
    $stmt = $conn->prepare("DELETE FROM customer WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header("Location: cdetails.php"); // Redirect back to details page
        exit();
    } else {
        die("Error deleting customer: " . $stmt->error);
    }
} else {
    die("Invalid customer ID.");
}
?>
