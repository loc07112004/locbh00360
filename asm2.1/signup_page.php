<!DOCTYPE html>
<html lang="en">

<head>
  <script>

  </script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <title>Registration Form</title>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-300">
  <div class="p-8 max-w-md w-full bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-6">Register</h2>
    <form action="signup_page.php" method="post">
      <div class="mb-4">
        <label for="fullname" class="block text-gray-700 text-sm font-bold mb-2">Full Name</label>
        <input id="fullname" name="fullname" type="text" placeholder="Enter your full name" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-indigo-500">
      </div>
      <div class="mb-4">
        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
        <input id="email" name="email" type="email" placeholder="Enter your email" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-indigo-500">
      </div>
      <div class="mb-6">
        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
        <input id="password" name="password" type="password" placeholder="Enter your password" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-indigo-500">
      </div>
      <div class="mb-6">
        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
        <input name="confirm_password" id="confirm_password" type="password" placeholder="Confirm your password" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-indigo-500">
      </div>

      <button type="submit" name="button_regist" class="w-full bg-indigo-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-indigo-600">Sign Up</button>

      <button type="submit" name="button_login" class="w-full bg-red-500 mt-5 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-indigo-600">Sign In</button>
    </form>
  </div>

  <?php
  // Database connection settings
  $_servername = "localhost";
  $_username = "root";
  $_password = "";
  $_dbname = "btec-student";
  $conn = new mysqli($_servername, $_username, $_password, $_dbname);

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the submitted data

    if (isset($_POST['button_regist'])) {
      $email = $_POST['email'];
      $fullname = $_POST['fullname'];
      $password = $_POST['password'];
      $confirm_password = $_POST['confirm_password'];
      $hash_password  = password_hash($password, PASSWORD_DEFAULT);
      // Check if the email already exists
      $query = "SELECT * FROM users WHERE email = '$email'";
      $result = $conn->query($query);

      if ($result->num_rows > 0) {
        // Email already exists, display error or take appropriate action
        echo '<script>alert("Email already exists!");</script>';
      } else {

        // Create a connection

        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        // Prepare the insert statement
        $stmt = $conn->prepare("INSERT INTO users (fullname, password, email) VALUES (?, ?, ?)");

        // Bind parameters and execute the statement
        $stmt->bind_param("sss", $fullname, $hash_password, $email);

        if ($stmt->execute()) {
          echo "New user created successfully!";
          header("Location: signin_page.php");
        } else {
          echo "Error: " . $stmt->error;
        }

        // Close the statement and the database connection
        $stmt->close();
        $conn->close();
      }
    } elseif (isset($_POST['button_login'])) {
      // Button 2 is clicked, redirect to page2.php
      header("Location: signin_page.php");
      exit(); // Make sure to exit after redirecting
    }


    exit();
  }
  ?>
</body>

</html>