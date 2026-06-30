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
  <title>College Fest</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: url('festt.webp') no-repeat center center fixed;
      background-size: cover;
      color: white;
    }
    header.navbar {
      position: fixed;
      top: 0;
      width: 100%;
      background: rgba(0, 0, 0, 0.7);
      padding: 15px;
      display: flex;
      justify-content: center;
      z-index: 999;
    }
    header.navbar a {
      color: #fff;
      margin: 0 20px;
      text-decoration: none;
      font-weight: bold;
      transition: color 0.3s;
    }
    header.navbar a:hover {
      color: #ffcc00;
    }
    .event-container {
      margin-top: 100px;
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(6px);
      padding: 40px;
      border-radius: 20px;
      text-align: center;
      box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
      width: 90%;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
    }

.info-box{
    max-width: 900px;
    margin: auto;
    background: rgba(0,0,0,0.55);
    backdrop-filter: blur(6px);
    padding: 30px;
    border-radius: 18px;
    box-shadow: 0 0 20px rgba(0,0,0,0.4);
}

.info-box h2{
    color:#ffcc00;
    margin-bottom:15px;
}

.info-box p{
    color:#fff;
    font-size:18px;
    line-height:1.7;
}

    h1 { font-size: 36px; margin-bottom: 10px; }
    p { font-size: 18px; line-height: 1.5; }
    section {
      padding: 60px 20px;
      text-align: center;
    }
  </style>
</head>
<body>

  <header class="navbar">
    <a href="#place">Place</a>
    <a href="dashboard.php">Homepage</a>
    <a href="#about">About</a>
  </header>

  <div class="event-container">
    <h1>College Fest 2025</h1>
    <p>Date: April 25–26, 2025</p>
    <p>Experience two days of fun, music, dance, and creativity!</p>
    <form id="registerForm">
      <input type="hidden" name="event_name" value="College Fest 2026">
      <button type="submit" style="margin-top: 20px; padding: 10px 20px; font-size: 16px;">🎟 Register</button>
    </form>
  </div>

  <section id="place">
    <div class="info-box">
        <h2>📍 Venue</h2>
        <p>
            Brainware University Grounds,<br>
            Main Auditorium & Open Field
        </p>
    </div>
</section>

  <section id="about">
    <div class="info-box">
        <h2>🎶 About College Fest</h2>
        <p>
            This grand annual celebration unites students through
            cultural performances, gaming zones, food stalls,
            exciting competitions, and unforgettable memories.
            Join us to celebrate creativity, friendship, and the
            true spirit of college life.
        </p>
    </div>
</section>

  <script>
    const form = document.getElementById('registerForm');
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      const formData = new FormData(form);
      fetch('register.php', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        alert(data.message);
        if (data.message === "Registration successful") {
          form.querySelector("button").innerText = "✅ Registered";
          form.querySelector("button").disabled = true;
        }
      })
      .catch(() => {
        alert("Something went wrong!");
      });
    });
  </script>

</body>
</html>