<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "db_conn.php";
session_start();

if (!isset($_SESSION['email'])) {
  echo json_encode(["message" => "User not logged in"]);
  exit();
}

$email = $_SESSION['email'];

$user_query = $conn->prepare("SELECT fullname, department, roll, semester, phone FROM users WHERE email = ?");
$user_query->bind_param("s", $email);
$user_query->execute();
$user_query->store_result();

if ($user_query->num_rows > 0) {
    $user_query->bind_result($fullname, $department, $roll, $semester, $phone);
    $user_query->fetch();

    $event_name = $_POST['event_name'];
$check = $conn->prepare("SELECT id FROM registrations WHERE email = ? AND event_name = ?");
$check->bind_param("ss", $email, $event_name);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo json_encode(["message" => "⚠️ You have already registered for this event."]);
    exit();
}
   $stmt = $conn->prepare("INSERT INTO registrations (student_name, email, event_name, department, roll, semester, phone) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $fullname, $email, $event_name, $department, $roll, $semester, $phone);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Registration successful"]);
    } else {
        echo json_encode(["message" => "Error occurred"]);
    }
} else {
    echo json_encode(["message" => "User not found"]);
}
?>