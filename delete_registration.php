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

    $stmt = $conn->prepare("DELETE FROM registrations WHERE id=?");
    $stmt->bind_param("i",$id);

    if($stmt->execute()){

        header("Location: admin.php?success=" . urlencode("✅ Registration deleted successfully."));

    }else{

        header("Location: admin.php?error=" . urlencode("❌ Failed to delete registration."));

    }

    exit();

}

header("Location: admin.php");
exit();
?>