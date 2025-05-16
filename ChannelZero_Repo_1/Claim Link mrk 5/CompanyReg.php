<?php
// Database connection
$servername = "localhost";       
$username = "root";              
$password = "";                  
$dbname = "claimlinkdb"; //DB name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Variables to store form data
$company_name = $tax_id = $registration_number = $contact_person = $company_email = $company_phone = $company_address = "";
$username = $password = $confirm_password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $company_name = mysqli_real_escape_string($conn, $_POST['company_name']);
    $tax_id = mysqli_real_escape_string($conn, $_POST['tax_id']);
    $registration_number = mysqli_real_escape_string($conn, $_POST['registration_number']);
    $contact_person = mysqli_real_escape_string($conn, $_POST['contact_person']);
    $company_email = mysqli_real_escape_string($conn, $_POST['company_email']);
    $company_phone = mysqli_real_escape_string($conn, $_POST['company_phone']);
    $company_address = mysqli_real_escape_string($conn, $_POST['company_address']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Password match check
    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
        exit;
    }

    // Check if username or email already exists
    $check_sql = "SELECT * FROM companydetails WHERE username = ? OR company_email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $username, $company_email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username or email already exists!";
        exit;
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert data using prepared statements
    $sql = "INSERT INTO companydetails
        (company_name, tax_id, registration_number, contact_person, company_email, company_phone, company_address, username, password) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $company_name, $tax_id, $registration_number, $contact_person, $company_email, $company_phone, $company_address, $username, $hashed_password);

    if ($stmt->execute()) {
        echo "Company registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Company Registration</title>
    <link rel="stylesheet" href="companyReg.css">
</head>
<body>

    <h2>Company Registration</h2>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <!-- Company Details -->
        <label for="company_name">Company Name:</label>
        <input type="text" name="company_name" id="company_name" required>

        <label for="tax_id">Tax ID:</label>
        <input type="text" name="tax_id" id="tax_id" required>

        <label for="registration_number">Registration Number:</label>
        <input type="text" name="registration_number" id="registration_number" required>

        <label for="contact_person">Contact Person:</label>
        <input type="text" name="contact_person" id="contact_person" required>

        <label for="company_email">Company Email:</label>
        <input type="email" name="company_email" id="company_email" required>

        <label for="company_phone">Phone Number:</label>
        <input type="text" name="company_phone" id="company_phone" required>

        <label for="company_address">Address:</label>
        <input type="text" name="company_address" id="company_address" required>

        <!-- Authentication -->
        <h3>Authentication & Security</h3>

        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <small>Password must be at least 8 characters long, and include uppercase, lowercase, numbers, and symbols.</small>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" required>

        <button type="submit">Register Company</button>
    </form>

    <script src="companyReg.js"></script>
</body>
</html>
