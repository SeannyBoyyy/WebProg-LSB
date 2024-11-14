<?php
include('../config/config.php'); // Database connection

$data = [
    'totalPrograms' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM programs"))['total'],
    'totalSpotlight' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM spotlight"))['total'],
    'totalNews' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM news"))['total'],
    'totalMerchandise' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM merch"))['total'],
    'totalEvents' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM events"))['total'],
    'upcomingEvents' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM events WHERE event_date >= CURDATE()"))['total'],
    'totalMessages' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM messages"))['total'],
    'registeredUsers' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM admins"))['total'],
];

// Return data as JSON
echo json_encode($data);
?>
