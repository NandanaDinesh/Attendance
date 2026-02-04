<?php
require "config.php";
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login    = $_POST["login"];
    $password = $_POST["password"];
    $stmt = $conn->prepare(
        "SELECT id, username, email, phone, password
         FROM users
         WHERE username = ? OR email = ? OR phone = ?"
    );
    if ($stmt) {
        $stmt->bind_param("sss", $login, $login, $login);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $username, $email, $phone, $hash);
            $stmt->fetch();
            if (password_verify($password, $hash)) {
                $_SESSION["user_id"]   = $id;
                $_SESSION["username"] = $username;
                header("Location: attendance.php");
                exit;
            }
        }
        $stmt->close();
    }
    $error = "Invalid login";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<center><h2>Sign in</h2>
<form method="post">
    <label>Username / Email / Phone</label><br>
    <input type="text" name="login" required><br><br>
    <label>Password</label><br>
    <input type="password" name="password" required><br><br>
    <button type="submit">Login</button>

</form>
<p style="color:red;"><?php echo $error; ?></p>
<a href="registration.php">Register</a>
</center>
</body>
</html>
