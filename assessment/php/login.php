<?php
$usernameErr = $passErr ="";
$username = $password ="";
 
function cleanInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
    } else {
        $username = cleanInput($_POST["username"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $username))
            {
            $usernameErr = "Only letters are allowed";
            }
        $username = str_replace(' ', '', $username);
        $username = strtolower($username);
    }
 
    // Password
    if (empty($_POST["password"])) {
        $passErr = "Password is required";
    } else {
        $password = cleanInput($_POST["password"]);
 
        if (strlen($password) < 8) {
            $passErr = "Password must be at least 8 characters";
        }
    }
 
}
?>
 
 
<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
   
</head>
 
<body>
    <h2>User Login</h2>
    <p><span class="required"></span></p>
 
    <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <table class="form-table">
 
            <tr>
                <td>Username <span class="required">*</span></td>
                <td>
                    <input type="text" name="username" value="<?= $username ?>">
                    <span class="error"><?= $usernameErr ?></span>
                </td>
            </tr>
 
            <tr>
                <td>Password <span class="required">*</span></td>
                <td>
                    <input type="password" name="password">
                    <span class="error"><?= $passErr ?></span>
                </td>
            </tr>
 
            <tr>
                <td></td>
                <td><input type="submit" value="Login"></td>
            </tr>
 
        </table>
    </form>
 
    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" &&
        !$usernameErr && !$passErr): ?>
       
        <h3>Login Data</h3>
        <table class="result-table">
            <tr><td>Username</td><td><?= $username ?></td></tr>
            <tr><td>Password</td><td><?= $password ?></td></tr>
        </table>
 
    <?php endif; ?>
 
</body>
</html>