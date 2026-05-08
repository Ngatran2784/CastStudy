<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require_once 'includes/db_config.php';

header('Content-Type: text/plain; charset=utf-8');

echo "=== SESSION DEBUG ===\n";
echo "Session Status: " . (isset($_SESSION['user']) ? 'Logged in' : 'Not logged in') . "\n";

if (isset($_SESSION['user'])) {
    echo "User ID: " . $_SESSION['user']['ID'] . "\n";
    echo "Username: " . $_SESSION['user']['Username'] . "\n";
    echo "Role: " . $_SESSION['user']['role'] . "\n";
    echo "Role == 2: " . (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 2 ? 'YES (admin)' : 'NO (not admin)') . "\n";
}

echo "\n=== DATABASE USERS ===\n";
$result = mysqli_query($conn, "SELECT ID, Username, role, Role FROM user");
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "ID: {$row['ID']}, Username: {$row['Username']}, role: {$row['role']}, Role: {$row['Role']}\n";
    }
} else {
    echo "Query error: " . mysqli_error($conn) . "\n";
}
?>
