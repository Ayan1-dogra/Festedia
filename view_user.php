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
    die("Invalid User ID");
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("User not found.");
}

$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>View User</title>

<style>

body{
margin:0;
font-family:Segoe UI,sans-serif;
background:#f4f6f9;
}

.container{

width:600px;
margin:60px auto;
background:#fff;
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

font-weight:bold;
width:220px;
background:#f8f9fa;

}

.back{

display:inline-block;
margin-top:25px;
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

<h2>👤 User Details</h2>

<table>

<tr>
<td>Full Name</td>
<td><?php echo htmlspecialchars($user['fullname']); ?></td>
</tr>

<tr>
<td>Email</td>
<td><?php echo htmlspecialchars($user['email']); ?></td>
</tr>

<tr>
<td>Department</td>
<td><?php echo htmlspecialchars($user['department']); ?></td>
</tr>

<tr>
<td>Roll Number</td>
<td><?php echo htmlspecialchars($user['roll']); ?></td>
</tr>

<tr>
<td>Semester</td>
<td><?php echo htmlspecialchars($user['semester']); ?></td>
</tr>

<tr>
<td>Phone Number</td>
<td><?php echo htmlspecialchars($user['phone']); ?></td>
</tr>

</table>

<center>

<a class="back" href="admin.php">
⬅ Back to Admin Panel
</a>

</center>

</div>

</body>
</html>