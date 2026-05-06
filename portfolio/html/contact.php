<?php
$firstnameErr = $lastnameErr = $genderErr = $emailErr = $reasonErr = $topicErr = "";
$firstname = $lastname = $gender = $email = $comment = "";
$reasons = [];
$topics = [];

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

    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
    } else {
        $gender = cleanInput($_POST["gender"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = cleanInput($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    $comment = cleanInput($_POST["comment"] ?? "");

    if (empty($_POST["reason"])) {
        $reasonErr = "Reason is required";
    } else {
        $reasons = array_map('cleanInput', $_POST["reason"]);
    }

if (empty($_POST["topic"])) {
        $topicErr = "Topic is required";
    } else {
        $topics = array_map('cleanInput', $_POST["topic"]);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact</title>
    <link rel="stylesheet" type="text/css" href="../css/contact.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <a href="../index.html">Index</a> |
                <a href="educations.html">Educations</a> |
                <a href="experience.html">Experience</a> |
                <a href="projects.html">Projects</a>
            </ul>
        </nav>
    </header>

    <h1>Contact</h1>

    <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <fieldset>
            <legend><strong>Contact</strong></legend>
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
                    <td><label>Gender <span class="required">*</span></label></td>
                    <td>
                        <input type="radio" name="gender" value="male"
                            <?= ($gender == "male") ? "checked" : "" ?>> Male
                        <input type="radio" name="gender" value="female"
                            <?= ($gender == "female") ? "checked" : "" ?>> Female
                        <span class="error"><?= $genderErr ?></span>
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
                    <td><label>Reason of Contact <span class="required">*</span></label></td>
                    <td>
                        <input type="checkbox" name="reason[]" value="Projects"
                            <?= in_array("Projects", $reasons) ? "checked" : "" ?>> Project
                        <input type="checkbox" name="reason[]" value="Thesis"
                            <?= in_array("Thesis", $reasons) ? "checked" : "" ?>> Thesis
                        <input type="checkbox" name="reason[]" value="Job"
                            <?= in_array("Job", $reasons) ? "checked" : "" ?>> Job
                        <span class="error"><?= $reasonErr ?></span>
                    </td>
                </tr>

                <tr>
                    <td><label>Topics <span class="required">*</span></label></td>
                    <td>
                        <input type="checkbox" name="topic[]" value="Web Development"
                            <?= in_array("Web Development", $topics) ? "checked" : "" ?>> Web Development
                        <input type="checkbox" name="topic[]" value="Mobile Development"
                            <?= in_array("Mobile Development", $topics) ? "checked" : "" ?>> Mobile Development
                        <input type="checkbox" name="topic[]" value="AI/ML Development"
                            <?= in_array("AI/ML Development", $topics) ? "checked" : "" ?>> AI/ML Development
                        <span class="error"><?= $topicErr ?></span>
                    </td>
                </tr>

                <tr>
                    <td><label for="consultation">Consultation Date:</label></td>
                    <td>
                        <input type="datetime-local" id="consultation" name="consultation" required>
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
        !$firstnameErr && !$lastnameErr && !$genderErr && !$emailErr && !$reasonErr && !$topicErr): ?>
        <h3>Submitted Values</h3>
        <table class="result-table">
            <tr><td>First Name</td><td><?= $firstname ?></td></tr>
            <tr><td>Last Name</td><td><?= $lastname ?></td></tr>
            <tr><td>Gender</td><td><?= $gender ?></td></tr>
            <tr><td>Email</td><td><?= $email ?></td></tr>
            <tr><td>Reason</td><td><?= implode(", ", $reasons) ?></td></tr>
            <tr><td>Topics</td><td><?= implode(", ", $topics) ?></td></tr>
            <tr><td>Comment</td><td><?= $comment ?></td></tr>
        </table>
    <?php endif; ?>

</body>
</html>