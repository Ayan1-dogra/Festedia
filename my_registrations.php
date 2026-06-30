<?php
session_start();
include "db_conn.php";

if (!isset($_SESSION['email'])) {
  header("Location: login.html");
  exit();
}

$email = $_SESSION['email'];
$query = $conn->prepare("SELECT event_name, registration_date FROM registrations WHERE email = ? ORDER BY registration_date DESC");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>My Registrations</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>My Event Registrations</h1>
    <nav>
      <a href="dashboard.php">Back to Dashboard</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>
  <section class="event-list">
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="event-box">
        <h2><?php echo htmlspecialchars($row['event_name']); ?></h2>
        <p><strong>Date:</strong> <?php echo $row['registration_date']; ?></p>
      </div>
    <?php endwhile; ?>
  </section>
</body>
</html>