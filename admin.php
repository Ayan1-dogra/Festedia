<?php
session_start();


if (
    !isset($_SESSION['is_admin']) ||
    $_SESSION['is_admin'] !== true ||
    $_SESSION['email'] !== "admin@festedia.com"
) {
    header("Location: login.html?error=" . urlencode("⛔ Access Denied! Admin Login Required."));
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Panel - Registered Users</title>
  <style>
    body{
    margin:0;
    padding:30px;
    font-family:Segoe UI,sans-serif;
    background:#eef3f8;
}

h1{
    color:#002244;
    text-align:center;
}

.dashboard{
    display:flex;
    justify-content:center;
    gap:25px;
    margin:30px 0;
    flex-wrap:wrap;
}

.card{
    width:220px;
    background:white;
    border-radius:15px;
    padding:25px;
    text-align:center;
    box-shadow:0 8px 18px rgba(0,0,0,.15);
    transition:.3s;
}

.card:nth-child(1){
    border-top:6px solid #007bff;
}

.card:nth-child(2){
    border-top:6px solid #28a745;
}

.card:nth-child(3){
    border-top:6px solid #ff9800;
}

.card:hover{
    transform:translateY(-6px);
}

.card h2{
    margin:0;
    color:#002244;
    font-size:20px;
}

.card p{
    font-size:34px;
    font-weight:bold;
    color:#0077ff;
    margin-top:10px;
}

table{
    width:90%;
    margin:auto;
    border-collapse:collapse;
    background:white;
    box-shadow:0 5px 15px rgba(0,0,0,.15);
}

table{
    width:100%;
    table-layout:auto;
}

th{
    background:#002244;
    color:white;
    padding:12px;
    letter-spacing:1px;
    font-size:16px;
}

td{
    padding:12px;
    border:1px solid #ddd;
    text-align:center;
}

.action-column{
    width:220px;
    white-space:nowrap;
    text-align:center;
}


tr:nth-child(even){
    background:#f8f8f8;
}

tr:hover{
    background:#dcecff;
    transition:.3s;
}

    table { border-collapse: collapse; width: 80%; margin: auto; background: white; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
    th { background-color: #002244; color: white; }
    h2 { text-align: center; }

.topbar{
    background:#002244;
    color:white;
    padding:18px 30px;
    border-radius:12px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.topbar h2{
    margin:0;
    font-size:24px;
}

.logout-btn{
    background:#dc3545;
    color:white;
    text-decoration:none;
    padding:10px 18px;
    border-radius:8px;
    font-weight:bold;
    transition:.3s;
}

.logout-btn:hover{
    background:#b02a37;
}

.card:hover{

transform:translateY(-8px);

box-shadow:0 12px 25px rgba(0,0,0,.25);

}

.toast{
position:fixed;
top:20px;
right:25px;
min-width:320px;
padding:16px 22px;
border-radius:12px;
color:#fff;
font-size:16px;
font-weight:bold;
box-shadow:0 10px 30px rgba(0,0,0,.25);
z-index:9999;
animation:slideIn .5s ease;
}

.toast.success{
background:#28a745;
}

.toast.error{
background:#dc3545;
}

.action-column{
    width:190px;
    white-space:nowrap;
    text-align:center;
}

@keyframes slideIn{

from{
opacity:0;
transform:translateX(120%);
}

to{
opacity:1;
transform:translateX(0);
}

}

  </style>
</head>
<body>

<?php
if(isset($_GET['success'])){
echo "<div class='toast success' id='toast'>"
.htmlspecialchars($_GET['success']).
"</div>";
}

if(isset($_GET['error'])){
echo "<div class='toast error' id='toast'>"
.htmlspecialchars($_GET['error']).
"</div>";
}
?>

<div class="topbar">

<div>
<h2>🎉 FESTEDIA ADMIN PANEL</h2>
<p>

Welcome, Administrator 👋

<br>

<?php
date_default_timezone_set("Asia/Kolkata");
echo date("d M Y | h:i A");
?>

</p>
</div>

<div>
<a href="logout.php" class="logout-btn">🚪 Logout</a>
</div>

</div>

<?php
$conn = new mysqli("localhost", "root", "", "eventdb"); 

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}



$totalUsers = $conn->query("SELECT COUNT(*) AS total FROM users")
                   ->fetch_assoc()['total'];

$totalRegistrations = $conn->query("SELECT COUNT(*) AS total FROM registrations")
                           ->fetch_assoc()['total'];

$totalEvents = 2; 

$result = $conn->query("SELECT * FROM users");

echo "<h1>🎉 FESTEDIA ADMIN DASHBOARD</h1>";

echo "<div class='dashboard'>

<div class='card'>
<h2>👥 Total Users</h2>
<p>$totalUsers</p>
</div>

<div class='card'>
<h2>🎟 Registrations</h2>
<p>$totalRegistrations</p>
</div>

<div class='card'>
<h2>📅 Events</h2>
<p>$totalEvents</p>
</div>

</div>";

echo "<h2 style='text-align:center;'>Registered Users</h2>";
echo "
<div style='text-align:center;margin:20px 0;'>
<input
type='text'
id='searchInput'
placeholder='🔍 Search by Name or Email...'
style='width:350px;
padding:12px;
border-radius:8px;
border:1px solid #ccc;
font-size:16px;'>
</div>";
echo "<table id='userTable'>

<tr>

<th>ID</th>

<th>Full Name</th>

<th>Email Address</th>

<th>Department</th>

<th>Semester</th>

<th>Phone</th>

<th class='action-column'>Actions</th>

</tr>";

while($row = $result->fetch_assoc()){

echo "

<tr>

<td>".$row['id']."</td>

<td>".$row['fullname']."</td>

<td>".$row['email']."</td>

<td>".$row['department']."</td>

<td>".$row['semester']."</td>

<td>".$row['phone']."</td>

<td class='action-column'>

<a href='view_user.php?id=".$row['id']."'
style='background:#007bff;color:white;padding:7px 12px;border-radius:6px;text-decoration:none;font-weight:bold;margin-right:5px;'>
👁 View
</a>

<a href='delete_user.php?id=".$row['id']."'
onclick=\"return confirm('Are you sure you want to delete this user?');\"
style='background:#dc3545;color:white;padding:7px 12px;border-radius:6px;text-decoration:none;font-weight:bold;'>
🗑 Delete
</a>

</td>

</tr>

";

}

echo "</table>";

echo "<br><br>";

echo "<h2 style='text-align:center;color:#002244;'>🎟 Event Registrations</h2>";

$regResult = $conn->query("SELECT * FROM registrations ORDER BY id DESC");

if($regResult->num_rows==0){

echo "<p style='text-align:center;color:red;font-size:18px;'>
No registrations found.
</p>";

}else{

echo "

<table style='margin-top:20px;'>

<tr>

<th>ID</th>

<th>Student Name</th>

<th>Email</th>

<th>Event</th>

<th>Department</th>

<th>Semester</th>

<th>Phone</th>

<th class='action-column'>Actions</th>

<th>Registration Date</th>

</tr>

";

while($reg = $regResult->fetch_assoc()){

echo "

<tr>

<td>".$reg['id']."</td>

<td>".$reg['student_name']."</td>

<td>".$reg['email']."</td>

<td>".$reg['event_name']."</td>

<td>".$reg['department']."</td>

<td>".$reg['semester']."</td>

<td>".$reg['phone']."</td>

<td class='action-column'>

<a href='view_registration.php?id=".$reg['id']."'
style='
background:#007bff;
color:white;
padding:8px 14px;
border-radius:8px;
text-decoration:none;
font-weight:bold;
margin-right:6px;
display:inline-block;
'>
👁 View
</a>

<a href='delete_registration.php?id=".$reg['id']."'
onclick=\"return confirm('Are you sure you want to delete this registration?');\"
style='
background:#dc3545;
color:white;
padding:8px 14px;
border-radius:8px;
text-decoration:none;
font-weight:bold;
display:inline-block;
'>
🗑 Delete
</a>

</td>

<td>".$reg['registration_date']."</td>

</tr>

";

}

echo "</table>";



echo "
<div style='text-align:center;margin:30px 0;'>

<a href='export_users.php'
style='
background:#28a745;
color:white;
padding:12px 22px;
border-radius:8px;
text-decoration:none;
font-weight:bold;
font-size:17px;
margin-right:15px;
display:inline-block;
'>
📥 Export Registered Users
</a>

<a href='export_registrations.php'
style='
background:#007bff;
color:white;
padding:12px 22px;
border-radius:8px;
text-decoration:none;
font-weight:bold;
font-size:17px;
display:inline-block;
'>
📥 Export Event Registrations
</a>

</div>";

}

$conn->close();
?>

<script>

const input=document.getElementById("searchInput");

input.addEventListener("keyup",function(){

let filter=input.value.toLowerCase();

let rows=document.querySelectorAll("#userTable tr");

for(let i=1;i<rows.length;i++){

let txt=rows[i].innerText.toLowerCase();

rows[i].style.display=
txt.includes(filter)
?
""
:
"none";

}

});

</script>

<div style="
margin-top:40px;
text-align:center;
color:gray;
font-size:15px;">

© 2026 FESTEDIA |
Developed by Ayan

</div>
<script>

setTimeout(function(){

let toast=document.getElementById("toast");

if(toast){

toast.style.transition="all .5s";

toast.style.opacity="0";

toast.style.transform="translateX(120%)";

}

},3000);

</script>
</body>
</html>
