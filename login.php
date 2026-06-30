<?php
session_start();
include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];
    if ($email === "admin@festedia.com" && $password === "festedia@2026") {
        $_SESSION['email'] = $email;
        $_SESSION['fullname'] = "Administrator";
        $_SESSION['is_admin'] = true;

        header("Location: admin.php");
        exit();
    }
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['email'] = $user['email'];
            $_SESSION['fullname'] = $user['fullname'];

            header("Location: dashboard.php");
            exit();

        } else {

            header("Location: login.html?error=" . urlencode("Invalid email or password"));
            exit();

        }

    } else {

        header("Location: login.html?error=" . urlencode("Invalid email or password"));
        exit();

    }
}
?>