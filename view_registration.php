<?php
session_start();

if (
    !isset($_SESSION['is_admin']) ||
    $_SESSION['is_admin'] !== true ||
    $_SESSION['email'] !== "admin@festedia.com"
) {
    header("Location: login.html?error=" . urlencode("Access Denied!"));
    exit();
}

include "db_conn.php";

if (!isset($_GET['id'])) {
    die("Invalid Registration ID");
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM registrations WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows == 0){
    die("Registration not found.");
}

$reg = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Registration Details</title>

<style>

body{
margin:0;
font-family:Segoe UI,sans-serif;
background:#f4f6f9;
}

.container{
width:650px;
margin:50px auto;
background:white;
padding:35px;
border-radius:15px;
box-shadow:0 8px 25px rgba(0,0,0,.15);
}

h2{
text-align:center;
color:#002244;
margin-bottom:30px;
}

table{
width:100%;
border-collapse:collapse;
}

td{
padding:14px;
border-bottom:1px solid #ddd;
font-size:17px;
}

td:first-child{
width:220px;
font-weight:bold;
background:#f8f9fa;
}

.back{
display:inline-block;
margin-top:30px;
padding:12px 22px;
background:#007bff;
color:white;
text-decoration:none;
border-radius:8px;
font-weight:bold;
}

.back:hover{
background:#0056b3;
}

</style>

</head>

<body>

<div class="container">

<h2>🎟 Event Registration Details</h2>

<table>

<tr>
<td>Student Name</td>
<td><?php echo htmlspecialchars($reg['student_name']); ?></td>
</tr>

<tr>
<td>Email</td>
<td><?php echo htmlspecialchars($reg['email']); ?></td>
</tr>

<tr>
<td>Event Name</td>
<td><?php echo htmlspecialchars($reg['event_name']); ?></td>
</tr>

<tr>
<td>Department</td>
<td><?php echo htmlspecialchars($reg['department']); ?></td>
</tr>

<tr>
<td>Roll Number</td>
<td><?php echo htmlspecialchars($reg['roll']); ?></td>
</tr>

<tr>
<td>Semester</td>
<td><?php echo htmlspecialchars($reg['semester']); ?></td>
</tr>

<tr>
<td>Phone Number</td>
<td><?php echo htmlspecialchars($reg['phone']); ?></td>
</tr>

<tr>
<td>Registration Date</td>
<td><?php echo htmlspecialchars($reg['registration_date']); ?></td>
</tr>

</table>

<center>

<a href="admin.php" class="back">
⬅ Back to Admin Panel
</a>

</center>

</div>

</body>
</html>