<?php
require "config.php";
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email    = $_POST["email"];
    $phone    = $_POST["phone"];
    $rawPassword = $_POST["password"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email address";
    }
    elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
        $message = "Phone number must be 10 digits";
    }
    elseif (strlen($rawPassword) < 6) {
        $message = "Password must be at least 6 characters";
    }
    else {
        $password = password_hash($rawPassword, PASSWORD_DEFAULT);
        $stmt = $conn->prepare(
                "INSERT INTO users (username, email, phone, password)
             VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("ssss", $username, $email, $phone, $password);
        if ($stmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            $message = "Registration failed";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
</head>
<body>
<center>
<form method="post">
    <label>Username</label><br>
    <input type="text" name="username" required><br><br>
    <label>Password</label><br>
    <input type="password" name="password" required><br><br>
    <label>Email</label><br>
    <input type="text" name="email" required><br><br>
    <label>Phone Number</label><br>
    <input type="text" name="phone" required><br><br>
    <button type="submit">Register</button>
</form>
<p style="color:red;"><?php echo $message; ?></p>
<a href="login.php">Already registered? Login</a>
</center>
</body>
</html>
