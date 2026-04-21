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

    <form method="post">

        <fieldset>
            <legend><strong>Contact Me</strong></legend>

            <table>

                <tr>
                    <td><label for="first name">First Name:</label></td>
                    <td><input type="text" id="first name" name="first name" required></td>
                </tr>

                <tr>
                    <td><label for="last name">Last Name:</label></td>
                    <td><input type="text" id="last name" name="last name" required></td>
                </tr>

                <tr>
                    <td><label>Gender:</label></td>
                    <td>
                        <input type="radio" name="gender" value="male"> Male
                        <input type="radio" name="gender" value="female"> Female
                    </td>
                </tr>

                <tr>
                    <td><label for="email">Email:</label></td>
                    <td><input type="email" id="email" name="email" required></td>
                </tr>

                <tr>
                    <td><label>Reason of Contact:</label></td>
                    <td>
                        <input type="checkbox" value="Projects"> Project
                        <input type="checkbox" value="Thesis"> Thesis
                        <input type="checkbox" value="Job"> Job
                    </td>
                </tr>

                <tr>
                    <td><label>Topics:</label></td>
                    <td>
                        <input type="checkbox" value="Web Development"> Web Development
                        <input type="checkbox" value="Mobile Development"> Mobile Development
                        <input type="checkbox" value="AI/ML Development"> AI/ML Development
                    </td>
                </tr>

                <tr>
                    <td><label for="consultation">Consultation Date:</label></td>
                    <td>
                        <input type="datetime-local" id="consultation" name="consultation" required>
                    </td>
                </tr>

                <td>
                    <input type="submit" value="Submit">
                    <input type="reset">
                </td>
                </tr>

            </table>

        </fieldset>

    </form>

</body>

</html>