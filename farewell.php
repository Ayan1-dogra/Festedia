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
  <title>Farewell Party</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;

    background:
        linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.45)),
        url('farewelll.jpg');

    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    background-attachment: fixed;

    color: white;
}

header.navbar {
    position: fixed;
    top: 0;
    width: 100%;
    background: rgba(0, 0, 0, 0.75);
    padding: 15px;
    display: flex;
    justify-content: center;
    z-index: 999;
    backdrop-filter: blur(6px);
}

header.navbar a {
    color: #fff;
    margin: 0 20px;
    text-decoration: none;
    font-weight: bold;
    transition: 0.3s;
}

header.navbar a:hover {
    color: #ffcc00;
}

.event-container {
    margin-top: 100px;
    background: rgba(0, 0, 0, 0.55);
    backdrop-filter: blur(8px);
    padding: 40px;
    border-radius: 20px;
    text-align: center;
    width: 90%;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.45);
}

h1 {
    font-size: 38px;
    margin-bottom: 10px;
    text-shadow: 3px 3px 10px rgba(0,0,0,0.9);
}

h2 {
    font-size: 32px;
    text-shadow: 3px 3px 10px rgba(0,0,0,0.9);
}

p {
    font-size: 20px;
    line-height: 1.8;
    text-shadow: 2px 2px 8px rgba(0,0,0,0.9);
}

section {
    width: 85%;
    margin: 40px auto;
    padding: 35px;
    border-radius: 20px;
    background: rgba(0, 0, 0, 0.30);
    backdrop-filter: blur(4px);
    text-align: center;
}

button {
    margin-top: 20px;
    padding: 12px 25px;
    font-size: 17px;
    border: none;
    border-radius: 10px;
    background: #ff9800;
    color: white;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background: #e68900;
    transform: scale(1.05);
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
    <h1>Farewell Party 2025</h1>
    <p>Date: April 26, 2025 | 10:00 AM – 04:00 PM</p>
    <p>Let’s celebrate the final memories together with laughter, love, and nostalgia 🎓🎉</p>
    <form id="registerForm">
      <input type="hidden" name="event_name" value="College Farewell Party 2026">
      <button type="submit" style="margin-top: 20px; padding: 10px 20px; font-size: 16px;">🎟 Register</button>
    </form>
  </div>

  <section id="place">
    <h2>📍 Venue</h2>
    <p>Auditorium Hall, Brainware University</p>
  </section>

  <section id="about">
    <h2>🎈 About the Farewell</h2>
    <p>The Farewell Party 2026 honors our outgoing batch with heartfelt memories, performances, and gratitude. Let’s give them a send-off they’ll never forget!</p>
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