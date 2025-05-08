<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-200 min-h-screen flex items-center justify-center px-4">

  <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-md space-y-6">
    <h1 class="text-2xl font-bold text-yellow-400 text-center">Login Now!</h1>

    <?php  
    if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
      $color = $_SESSION['status'] == "200" ? "text-green-400" : "text-red-500";
      echo "<p class='text-center font-semibold {$color}'>{$_SESSION['message']}</p>";
    }
    unset($_SESSION['message']);
    unset($_SESSION['status']);
    ?>

    <form action="core/handleForms.php" method="POST" class="space-y-4">
      <input type="hidden" name="action" value="login">
      <div>
        <label class="block mb-1 text-blue-300">Username</label>
        <input type="text" name="username" class="w-full p-2 rounded bg-gray-900 border border-gray-700 text-white" required>
      </div>
      <div>
        <label class="block mb-1 text-blue-300">Password</label>
        <input type="password" name="password" class="w-full p-2 rounded bg-gray-900 border border-gray-700 text-white" required>
      </div>
      <input type="submit" name="loginUserBtn" value="Login" class="w-full bg-yellow-400 text-gray-900 font-bold py-2 px-4 rounded hover:bg-yellow-300 transition">
    </form>

    <p class="text-center text-gray-400 text-sm">Don't have an account? <a href="register.php" class="text-blue-400 hover:underline">Register here</a></p>
  </div>
</body>
</html>
