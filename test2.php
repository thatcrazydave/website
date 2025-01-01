<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User  Settings</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    /* General Styles */
body {
  font-family: Arial, Helvetica, sans-serif;
  color: #FFF;
  margin: 0;
  padding: 0;
  background-color: #2C2F33;
}

/* Sidebar Styles */
.sidebar {
  width: 250px;
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  background-color: #2C2F33;
  padding: 20px;
  overflow-y: auto;
  border-radius: 10px;
  box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
}

.sidebar h3 {
  font-size: 18px;
  margin-bottom: 15px;
  color: #7289DA;
}

/* Search Bar Styles */
.search {
  position: relative;
  background-color: #36393F;
  border-radius: 5px;
  padding: 10px;
  margin-bottom: 20px;
}

.search input {
  width: 100%;
  background-color: transparent;
  border: none;
  color: #FFF;
  padding: 10px;
  font-size: 14px;
}

.search input:focus {
  outline: none;
  box-shadow: 0 0 0 2px #7289DA;
}

.search i {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  color: #FFF;
  pointer-events: none;
 }

/* Settings List Styles */
.settings-list {
  list-style: none;
  padding: 0;
}

.settings-list li {
  padding: 10px 0;
  border-bottom: 1px solid #4F545C;
}

.settings-list li:last-child {
  border-bottom: none;
}

.settings-list li a {
  color: #FFF;
  text-decoration: none;
  transition: color 0.3s;
}

.settings-list li a:hover {
  color: #7289DA;
}

/* Responsive Styles */
@media (max-width: 768px) {
  .sidebar {
    width: 100%;
    height: auto;
    position: relative;
  }
}
  </style>
</head>
<body>
  <div class="sidebar">
    <div class="search">
      <input type="text" placeholder="Search..." aria-label="Search">
      <i class="fas fa-search" aria-hidden="true"></i>
    </div>
    <h3>USER SETTINGS</h3>
    <ul class="settings-list">
      <li><a href="#" aria-label="My Account">My Account</a></li>
      <li><a href="edit.php" aria-label="Profiles">Profiles</a></li>
      <li><a href="#" aria-label="Content & Social">Content & Social</a></li>
      <li><a href="#" aria-label="Data & Privacy">Data & Privacy</a></li>
      <li><a href="#" aria-label="Family Center">Family Center</a></li>
      <li><a href="#" aria-label="Authorized Apps">Authorized Apps</a></li>
      <li><a href="#" aria-label="Devices">Devices</a></li>
      <li><a href="#" aria-label="Connections">Connections</a></li>
      <li><a href="#" aria-label="Clips">Clips</a></li>
    </ul>

    <h3>BILLING SETTINGS</h3>
    <ul class="settings-list">
      <li><a href="#" aria-label="Nitro">Nitro</a></li>
      <li><a href="#" aria-label="Server Boost">Server Boost</a></li>
      <li><a href="#" aria-label="Subscriptions">Subscriptions</a></li>
      <li><a href="#" aria-label="Gift Inventory">Gift Inventory</a></li>
      <li><a href="#" aria-label="Billing">Billing</a></li>
    </ul>

    <h3>APP SETTINGS</h3>
    <ul class="settings-list">
      <li><a href="#" aria-label="Appearance">Appearance</a></li>
      <li><a href="#" aria-label="Accessibility">Accessibility</a></li>
      <li><a href="#" aria-label="Voice & Video">Voice & Video</a></li>
      <li><a href="#" aria-label="Chat">Chat</a></li>
      <li><a href="logout.php" aria-label="Logout">Logout</a></li>
    </ul>
  </div>
</body>
</html>