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
header('Content-Disposition: attachment; filename=event_registrations.csv');

$output = fopen('php://output', 'w');
fputcsv($output, array(
    'ID',
    'Student Name',
    'Email',
    'Event Name',
    'Department',
    'Roll Number',
    'Semester',
    'Phone Number',
    'Registration Date'
));

$result = $conn->query("SELECT * FROM registrations ORDER BY id ASC");

while($row = $result->fetch_assoc()){

    fputcsv($output, array(
        $row['id'],
        $row['student_name'],
        $row['email'],
        $row['event_name'],
        $row['department'],
        $row['roll'],
        $row['semester'],
        $row['phone'],
        $row['registration_date']
    ));

}

fclose($output);
exit();
?>