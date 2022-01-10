<div id='sidebar' class="col-md-2 bg-dark">
  <div id="sidebar-field">
    <a href="home.php" class="sidebar-item">Dashboard</a>
  </div>
  <div id="sidebar-field">
    <a href="employee.php" class="sidebar-item">Employee</a>
  </div>
  <div id="sidebar-field">
    <a href="student.php" class="sidebar-item">Student</a>
  </div>
  <div id="sidebar-field">
    <a href="attendance.php" class="sidebar-item">Attendance</a>
  </div>
  <?php if ($_SESSION["user_role"] == 1) { ?>
  <div id="sidebar-field">
    <a href="users.php" class="sidebar-item">Users</a>
  </div>
  <div id="sidebar-field">
    <a href="settings.php" class="sidebar-item">Settings</a>
  </div>
  <?php	} ?>
</div>