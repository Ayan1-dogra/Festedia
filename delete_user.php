<?php
session_start();

if (
    !isset($_SESSION['is_admin']) ||
    $_SESSION['is_admin'] !== true
) {
    header("Location: login.html");
    exit();
}

include "db_conn.php";

if(isset($_GET['id'])){

    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT email FROM users WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 0){
        header("Location: admin.php?error=" . urlencode("❌ User not found."));
        exit();
    }

    $user = $result->fetch_assoc();
    $email = $user['email'];
    $delReg = $conn->prepare("DELETE FROM registrations WHERE email=?");
    $delReg->bind_param("s", $email);
    $delReg->execute();
    $delUser = $conn->prepare("DELETE FROM users WHERE id=?");
    $delUser->bind_param("i", $id);

    if($delUser->execute()){

        header("Location: admin.php?success=" . urlencode("✅ User and all registrations deleted successfully."));

    }else{

        header("Location: admin.php?error=" . urlencode("❌ Failed to delete user."));

    }

    exit();

}else{

    header("Location: admin.php?error=" . urlencode("❌ Invalid User ID."));
    exit();

}
?>