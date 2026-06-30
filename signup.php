<?php
include "db_conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $roll = $_POST['roll'];
    $semester = $_POST['semester'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: signup.html?error=" . urlencode("Invalid email format"));
        exit();
    }
if (strtolower(trim($email)) === "admin@festedia.com") {
    header("Location: signup.html?error=" . urlencode("🚫 This email is reserved for the administrator. Please use another email address."));
    exit();
}
    if (!preg_match('/^[6-9]\d{9}$/', $phone)) {
        header("Location: signup.html?error=" . urlencode("Invalid mobile number"));
        exit();
    }
$checkPhone = $conn->prepare("SELECT id FROM users WHERE phone = ?");
$checkPhone->bind_param("s", $phone);
$checkPhone->execute();
$phoneResult = $checkPhone->get_result();

if ($phoneResult->num_rows > 0) {
    header("Location: signup.html?error=" . urlencode("Mobile number already registered"));
    exit();
}
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/', $password)) {
        header("Location: signup.html?error=" . urlencode("Weak password: include upper, lower, number, symbol"));
        exit();
    }
    if ($password !== $confirm_password) {
        header("Location: signup.html?error=" . urlencode("Passwords do not match"));
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (fullname, email, password, department, roll, semester, phone) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $fullname, $email, $hashed_password, $department, $roll, $semester, $phone);

    if ($stmt->execute()) {
        header("Location: login.html?success=" . urlencode("Account created successfully"));
        exit();
    } else {
        if ($conn->errno === 1062) {
    header("Location: signup.html?error=" . urlencode("This email address is already registered."));
    exit();
        } else {
            header("Location: signup.html?error=" . urlencode("Signup failed. Please try again."));
            exit();
        }
    }
}
?>