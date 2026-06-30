<?php
session_start();
if (!isset($_SESSION['email'])) {
  header("Location: login.html");
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="style.css?v=1.1">
</head>
<body>
  <header>
    <div class="welcome-box">

<h1>👋 Welcome Back</h1>

<h2><?php echo $_SESSION['email']; ?></h2>

<p>Explore and register for upcoming college events.</p>

</div>
    <nav>
      <a href="my_registrations.php">My Registrations</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>
  <div class="dashboard-cards">

    <div class="dashboard-card">
        <h3>🎉 Events</h3>
        <p>2</p>
    </div>

    <div class="dashboard-card">
        <h3>🎟 My Registrations</h3>
        <p>View from Menu</p>
    </div>

    <div class="dashboard-card">
        <h3>📅 Upcoming</h3>
        <p>2 Events</p>
    </div>

</div>
<div class="dashboard-title">
    <h2>🎉 Upcoming Events</h2>
    <p>Choose an event and complete your registration.</p>
</div>
  <section class="event-list">
    <div class="event-box">
      <h2>🎉 College Fest</h2>
      <p>Music, Dance, Fun Activities & unforgettable campus memories. Join our most exciting College Fest of 2026!</p>
      <a href="fest.php">View Details</a>
    </div>
    <div class="event-box">
      <h2>🎓 Farewell Party</h2>
      <p>Say goodbye to seniors with love and celebration.</p>
      <a href="farewell.php">View Details</a>
    </div>
  </section>
</body>
</html>