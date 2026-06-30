<?php
session_start();

if (
    !isset($_SESSION['is_admin']) ||
    $_SESSION['is_admin'] !== true ||
    $_SESSION['email'] !== "admin@festedia.com"
) {
    header("Location: login.html");
    exit();
}

include "db_conn.php";

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=registered_users.csv');

$output = fopen('php://output', 'w');

fputcsv($output, array(
    'ID',
    'Full Name',
    'Email',
    'Department',
    'Roll Number',
    'Semester',
    'Phone Number'
));

$result = $conn->query("SELECT * FROM users ORDER BY id ASC");

while($row = $result->fetch_assoc()){

    fputcsv($output, array(
        $row['id'],
        $row['fullname'],
        $row['email'],
        $row['department'],
        $row['roll'],
        $row['semester'],
        $row['phone']
    ));

}

fclose($output);
exit();
?>