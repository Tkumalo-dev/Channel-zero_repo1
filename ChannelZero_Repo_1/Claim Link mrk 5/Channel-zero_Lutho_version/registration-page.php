<?php
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection details
    $host = "localhost";
    $user = "root";
    $password = ""; // use your MySQL password if set
    $dbname = "users_db";

    // Connect to database
    $conn = new mysqli($host, $user, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $first_name   = $_POST['first_name'];
    $middle_name  = $_POST['middle_name'];
    $last_name    = $_POST['last_name'];
    $dob          = $_POST['dob'];
    $gender       = $_POST['gender'];
    $nationality  = $_POST['nationality'];
    $id_number    = $_POST['id_number'];
    $email        = $_POST['email'];
    $mobile       = $_POST['mobile'];

    // Insert into database
    $sql = "INSERT INTO users (first_name, middle_name, last_name, dob, gender, nationality, id_number, email, mobile)
            VALUES ('$first_name', '$middle_name', '$last_name', '$dob', '$gender', '$nationality', '$id_number', '$email', '$mobile')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registration successful!');</script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <style>
        * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
        }

        body {
          height: 100vh;
          width: 100vw;
          display: flex;
          background: #1e1e1e;
          font-family: "Poppins", sans-serif;
        }

        .container {
          width: 100%;
          height: 100%;
          display: flex;
          background-color: #f0f2ff;
          overflow: hidden;
        }

        .left-section {
          flex: 1;
          padding: 40px;
          display: flex;
          flex-direction: column;
          background-color: #f0f2ff;
          overflow-y: auto;
        }

        .left-section h2 {
          margin-bottom: 20px;
          font-size: 24px;
          font-weight: bold;
          color: #1a1a1a;
          text-align: center;
        }

        .left-section h3 {
          margin: 15px 0 10px;
          font-size: 16px;
          color: #333;
          border-bottom: 1px solid #ddd;
          padding-bottom: 5px;
        }

        .registration-form {
          display: flex;
          flex-direction: column;
        }

        .registration-form label {
          margin-bottom: 5px;
          font-size: 14px;
          color: #333;
          margin-top: 8px;
        }

        .registration-form input,
        .registration-form select {
          margin-bottom: 5px;
          padding: 12px;
          border: 1px solid #ccc;
          border-radius: 25px;
          outline: none;
          font-family: "Poppins", sans-serif;
          font-size: 14px;
        }

        .registration-form small {
          font-size: 12px;
          color: #666;
          margin-bottom: 15px;
          display: block;
        }

        .registration-form button {
          padding: 12px;
          background-color: #7881f5;
          border: none;
          color: white;
          border-radius: 25px;
          cursor: pointer;
          transition: background 0.3s;
          font-weight: bold;
          margin-top: 20px;
          font-size: 16px;
        }

        .registration-form button:hover {
          background-color: #5a6de0;
        }

        .login-text {
          font-size: 13px;
          margin-top: 20px;
          text-align: center;
        }

        .login-text a {
          font-weight: bold;
          color: #1a1a1a;
          text-decoration: none;
        }

        /* Scrollbar styling */
        .left-section::-webkit-scrollbar {
          width: 8px;
        }

        .left-section::-webkit-scrollbar-track {
          background: #f1f1f1;
          border-radius: 10px;
        }

        .left-section::-webkit-scrollbar-thumb {
          background: #7881f5;
          border-radius: 10px;
        }

        .left-section::-webkit-scrollbar-thumb:hover {
          background: #5a6de0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-section">
            <h2>Registration Form</h2>
          <form action="registration-page.php" method="POST">
  <input type="text" name="first_name" placeholder="First Name" required><br>
  <input type="text" name="middle_name" placeholder="Middle Name"><br>
  <input type="text" name="last_name" placeholder="Last Name" required><br>
  <input type="date" name="dob" required><br>
  <input type="text" name="gender" placeholder="Gender" required><br>
  <input type="text" name="nationality" placeholder="Nationality" required><br>
  <input type="text" name="id_number" placeholder="ID Number" required><br>
  <input type="email" name="email" placeholder="Email" required><br>
  <input type="text" name="mobile" placeholder="Mobile" required><br>
  <button type="submit">Register</button>
</form>

            <p class="login-text">
                Already have an account?
                <a href="login.html">Login Here</a>
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle form submission
            const registerForm = document.querySelector('.registration-form');
            if (registerForm) {
              registerForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Get password values
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirm-password').value;
                
                // Check if passwords match
                if (password !== confirmPassword) {
                  alert('Passwords do not match!');
                  return;
                }
                
                // Basic password strength check
                if (password.length < 8) {
                  alert('Password must be at least 8 characters long');
                  return;
                }
                
                // Collect all form data (in a real app, you'd send this to a server)
                const formData = {
                  firstName: document.getElementById('first-name').value,
                  lastName: document.getElementById('last-name').value,
                  email: document.getElementById('email').value,
                  username: document.getElementById('username').value
                  // Add other fields as needed
                };
              });
            }
          
            // Add password visibility toggle
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirm-password');
            const togglePassword = (input) => {
              const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
              input.setAttribute('type', type);
            };
          
            // Add eye icons next to password fields (you'll need to add these elements to your HTML)
            const addPasswordToggles = () => {
              [passwordInput, confirmPasswordInput].forEach(input => {
                if (input) {
                  const eyeIcon = document.createElement('span');
                  eyeIcon.innerHTML = '👁️';
                  eyeIcon.style.cursor = 'pointer';
                  eyeIcon.style.marginLeft = '-30px';
                  eyeIcon.addEventListener('click', () => togglePassword(input));
                  input.insertAdjacentElement('afterend', eyeIcon);
                }
              });
            };
          
            addPasswordToggles();
        });
    </script>
</body>
</html>