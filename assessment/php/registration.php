<?php
$firstnameErr = $lastnameErr = $contactErr = $emailErr = $passwordErr = "";
$firstname = $lastname = $contact = $email = $password = "";

function cleanInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["firstname"])) {
        $firstnameErr = "First name is required";
    } else {
        $firstname = cleanInput($_POST["firstname"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $firstname)) {
            $firstnameErr = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["lastname"])) {
        $lastnameErr = "Last name is required";
    } else {
        $lastname = cleanInput($_POST["lastname"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $lastname)) {
            $lastnameErr = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = cleanInput($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["contact"])) {
        $contactErr = "Contact is required";
    } else {
        $contact = cleanInput($_POST["contact"]);
        if (!preg_match("/^[0-9+\-() ]*$/", $contact)) {
            $contactErr = "Only numbers allowed";
        }
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = cleanInput($_POST["password"]);
 
        if (strlen($password) < 8) {
            $passwordErr = "Password must be at least 8 characters";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Signup</title>
</head>
<body>

<form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <fieldset>
        <legend><strong>Signup</strong></legend>
        <table>
            <tr>
                <td>First Name <span class="required">*</span></td>
                <td>
                    <input type="text" name="firstname" value="<?= $firstname ?>">
                    <span class="error"><?= $firstnameErr ?></span>
                </td>
            </tr>
            <tr>
                <td>Last Name <span class="required">*</span></td>
                <td>
                    <input type="text" name="lastname" value="<?= $lastname ?>">
                    <span class="error"><?= $lastnameErr ?></span>
                </td>
            </tr>
            <tr>
                <td>Email <span class="required">*</span></td>
                <td>
                    <input type="text" name="email" value="<?= $email ?>">
                    <span class="error"><?= $emailErr ?></span>
                </td>
            </tr>
            <tr>
                <td>Contact <span class="required">*</span></td>
                <td>
                    <input type="text" name="contact" value="<?= $contact ?>">
                    <span class="error"><?= $contactErr ?></span>
                </td>
            </tr>
            <tr>
                <td>Password <span class="required">*</span></td>
                <td>
                    <input type="password" name="password">
                    <span class="error"><?= $passwordErr ?></span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" value="Submit">
                    <input type="reset" value="Reset">
                </td>
            </tr>
        </table>
    </fieldset>
</form>

<?php if ($_SERVER["REQUEST_METHOD"] == "POST" &&
        !$firstnameErr && !$lastnameErr && !$emailErr && !$contactErr && !$passwordErr): ?>
    <h3>Submitted Values</h3>
    <table>
        <tr><td>First Name</td><td><?= $firstname ?></td></tr>
        <tr><td>Last Name</td><td><?= $lastname ?></td></tr>
        <tr><td>Email</td><td><?= $email ?></td></tr>
        <tr><td>Contact</td><td><?= $contact ?></td></tr>
        <tr><td>Password</td><td><?= $password ?></td></tr>
    </table>
<?php endif; ?>

</body>
</html>