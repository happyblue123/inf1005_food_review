<?php
$email = $errorMsg = "";
$success = true;


if (empty($_POST["name"])) {
    $errorMsg .= "Name is required.<br>";
    $success = false;
} else {
    $name = sanitize_input($_POST["name"]);

}
if (empty($_POST["email"])) {
    $errorMsg .= "Email is required.<br>";
    $success = false;
} else {
    $email = sanitize_input($_POST["email"]);
    // Additional check to make sure e-mail address is well-formed.
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg .= "Invalid email format.";
        $success = false;
    }
}
if (empty($_POST["pwd"])) {
    $errorMsg .= "Password is required.<br>";
    $success = false;
} else {
    $password = $_POST["pwd"];
}
if (empty($_POST["pwd_confirm"])) {
    $errorMsg .= "Password confirmation required.<br>";
    $success = false;
} else {
    $password_confirm = $_POST["pwd_confirm"];
    if ($password != $password_confirm) {
        $errorMsg .= "Passwords do not match.<br>";
        $success = false;
    }
}
if ($success) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    echo "<h4>Registration successful!</h4>";
    echo "<p>Name: " . $name;
    echo "<p>Email: " . $email;
    echo "<p>Your password has been securely stored.</p>";
} else {
    echo "<h4>The following input errors were detected:</h4>";
    echo "<p>" . $errorMsg . "</p>";
}
/*
 * Helper function that checks input for malicious or unwanted content.
 */
function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
/*
 * Helper function to write the member data to the database.
 */
function saveMemberToDB()
{
    global $name, $email, $hashed_password, $errorMsg, $success;
    // Create database connection.
    $config = parse_ini_file('/var/www/private/db-config.ini');
    if (!$config) {
        $errorMsg = "Failed to read database config file.";
        $success = false;
    } else {
        $conn = new mysqli(
            $config['servername'],
            $config['username'],
            $config['password'],
            $config['dbname']
        );
        // Check connection
        if ($conn->connect_error) {
            $errorMsg = "Connection failed: " . $conn->connect_error;
            $success = false;
        } else {
            // Prepare the statement:
            $stmt = $conn->prepare("INSERT INTO users
(name, email, password) VALUES (?, ?, ?)");
            // Bind & execute the query statement:
            $stmt->bind_param("ssss", $name, $email, $hashed_password);
            if (!$stmt->execute()) {
                $errorMsg = "Execute failed: (" . $stmt->errno . ") " .
                    $stmt->error;
                $success = false;
            }
            $stmt->close();
        }
        $conn->close();
    }
}
saveMemberToDB();
?>