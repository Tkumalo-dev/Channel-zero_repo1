<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="signup.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-up page</title>
</head>
<body>
    <div class="form-box" id="signup-form">
    <form action="signup.php" method="post">
    <div id="title"><h2>Signup</h2></div>
    <input type="text" name="name" placeholder="Enter Name" required  />
    <input type="email" name="email" placeholder="Enter Email" required />
    <input type="password" name="password" placeholder="Enter Password" required />
    
    <!-- Dropdown for role selection -->
    <select name="role" required>
      <option value="" disabled selected>Select Role</option>
      <option value="user">User</option>
       <option value="business">Business</option>
   
    </select>

    <button name="submit" type="submit">Register</button>

    <p>Already have an account? 
      <a href="login.php">Login</a>
    </p>

  </form>
</div>

</body>
</html>

<?php 


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $name = $_POST['user_fullname'];
    $email = $_POST['user_email'];
    $password = $_POST['user_password'];
    $role = $_POST['role'];

    // Validate the inputs
    if(empty($name) || empty($email) || empty($password) || empty($role)) {
        echo "All fields are required.";
    } else {
        // Save to database or perform other actions
        echo "Registration successful!";
    }
}

// if ($role == 'user') {
//     // Redirect to user dashboard
//     header("Location: user_dashboard.php");
// } elseif ($role == 'business') {
//     // Redirect to business dashboard
//     header("Location: business_dashboard.php");
// } else {
//     echo "Invalid role selected.";
// }





?>