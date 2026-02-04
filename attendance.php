<?php
require "config.php";
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Attendance</title>
</head>
<body>
Welcome, <?php echo $_SESSION["username"]; ?>
<h2>Attendance </h2>
<h2>PAYROLL</h2>
<script>
    setTimeout(function(){
        window.location.href = "login.php";
    }, 5000);
</script>

</body>
</html>
